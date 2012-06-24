<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
 *
 * @category  bnetlib
 * @package   Connection
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Connection;

use Buzz\Browser;
use Buzz\Util\Url;
use Buzz\Client\AbstractCurl;
use bnetlib\Exception\ClientException;

/**
 * @category  bnetlib
 * @package   Connection
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Buzz extends AbstractConnection
{
    /**
     * @param Browser $client
     * @param array   $option
     */
    public function __construct(Browser $client = null, array $option = null)
    {
        $this->client = ($client) ?: new Browser();

        if ($this->client->getClient() instanceof AbstractCurl) {
            $this->client->getClient()->setOption(
                CURLOPT_USERAGENT,
                'bnetlib/' . self::VERSION . ' Zend\Http\Client (PHP)'
            );
        }

        if ($option !== null) {
            $this->setOptions($option);
        }
    }

    /**
     * @inheritdoc
     */
    public function request(array $params)
    {
        try {
            $headers = array();
            $url     = new Url($params['url']);

            // Buzz cannot handle gziped content yet <@:(
            //$headers[] = 'Accept-Encoding: gzip,deflate';

            if ($params['config']->isAuthenticationPossible() === true
                && $this->option['keys']['public'] !== null
                && $this->option['keys']['private'] !== null) {
                /**
                 * Note: DATE_RFC1123 my not be RFC 1123 compliant, depending on your platform.
                 * @link http://www.php.net/manual/de/function.gmdate.php#25031
                 */
                $date = gmdate('D, d M Y H:i:s \G\M\T');
                $path = $url->getPath();
                $headers[] = 'Date: ' . $date;
                $headers[] = 'Authorization: '. $this->signRequest('GET', $date, $path);

            }

            if (isset($params['lastmodified'])) {
                $headers[] = 'If-Modified-Since: ' . $params['lastmodified'];
            }

            $response = $this->client->get($url, $headers);
            $body     = $response->getContent();
            $headers  = null;

            if ($this->option['responseheader']) {
                $headers = array();
                $temp    = $response->getHeaders();

                foreach ($temp as $header) {
                    if (substr($header, 0, 5) === 'HTTP/') {
                        continue;
                    }
                    list($key, $value) = explode(': ', $header);
                    $headers[$key]     = $value;
                }

                $this->lastResponseHeaders = $headers;
            }
        } catch (\Exception $e) {
            throw new ClientException('Client exception catched, use getPrevious().', 0, $e);
        }

        return $this->createResponse($params['config']->isJson(), $response->getStatusCode(), $body, $headers);
    }
}
