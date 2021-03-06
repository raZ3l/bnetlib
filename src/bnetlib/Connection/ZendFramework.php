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

use Zend\Http\Client;
use Zend\Http\Request;
use bnetlib\Exception\ClientException;

/**
 * @category  bnetlib
 * @package   Connection
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ZendFramework extends AbstractConnection
{
    /**
     * @param Client $client
     * @param array  $option
     */
    public function __construct(Client $client = null, array $option = null)
    {
        $this->client = ($client) ?: new Client();
        $this->client->setOptions(array(
            'useragent' => 'bnetlib/' . self::VERSION . ' Zend\Http (PHP)'
        ));

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
            $request  = new Request();
            $headers  = $request->getHeaders();
            $request->setUri($params['url']);
            $headers->addHeaderLine('Accept-Encoding', 'gzip,deflate');

            if ($params['config']->isAuthenticationPossible() === true
                && $this->option['keys']['public'] !== null
                && $this->option['keys']['private'] !== null) {
                /**
                 * Note: DATE_RFC1123 my not be RFC 1123 compliant, depending on your platform.
                 * @link http://www.php.net/manual/de/function.gmdate.php#25031
                 */
                $date = gmdate('D, d M Y H:i:s \G\M\T');
                $path = $request->getUri()->getPath();
                $headers->addHeaderLine('Date', $date);
                $headers->addHeaderLine('Authorization', $this->signRequest('GET', $date, $path));

            }

            if (isset($params['lastmodified'])) {
                $headers->addHeaderLine('If-Modified-Since', $params['lastmodified']);
            }

            $response = $this->client->send($request);
            $body     = $response->getBody();
            $headers  = null;

            if ($this->option['responseheader']) {
                $headers = $response->getHeaders()->toArray();
                $this->lastResponseHeaders = $headers;
            }
        } catch (\Exception $e) {
            throw new ClientException('Client exception catched, use getPrevious().', 0, $e);
        }

        return $this->createResponse($params['config']->isJson(), $response->getStatusCode(), $body, $headers);
    }
}
