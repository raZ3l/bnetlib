<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @category  bnetlib
 * @package   Connection
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Connection;

use Aura\Http\Headers;
use Aura\Http\Cookies;
use Aura\Http\Request;
use Aura\Http\Factory\Header;
use Aura\Http\Factory\Cookie;
use Aura\Http\Request\Response;
use Aura\Http\Request\Adapter\Curl;
use Aura\Http\Factory\ResponseStack;
use Aura\Http\Request\ResponseBuilder;
use bnetlib\Exception\ClientException;
use Aura\Http\Request\Adapter\AdapterInterface;

/**
 * @category  bnetlib
 * @package   Connection
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Aura extends AbstractConnection
{
    /**
     * @param AdapterInterface $adapter An AuraPHP.Http adapter (cURL or stream)
     * @param array            $option
     */
    public function __construct(AdapterInterface $adapter = null, array $option = null)
    {
        $headers = new Headers(new Header());
        $cookies = new Cookies(new Cookie());

        if ($adapter === null) {
            $response        = new Response($headers, $cookies);
            $responseBuilder = new ResponseBuilder($response, new ResponseStack());

            $adapter         = new Curl($responseBuilder);
        }

        $this->client = new Request(
            $adapter,
            $headers,
            $cookies,
            array('user_agent' => 'bnetlib/' . self::VERSION . ' AuraPHP.Http (PHP)')
        );

        $this->client->setHeader('Accept-Encoding', 'gzip,deflate');

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
            if ($params['config']->isAuthenticationPossible() === true
                && $this->option['keys']['public'] !== null
                && $this->option['keys']['private'] !== null) {
                /**
                 * Note: DATE_RFC1123 my not be RFC 1123 compliant, depending on your platform.
                 * @link http://www.php.net/manual/de/function.gmdate.php#25031
                 */
                $date = gmdate('D, d M Y H:i:s \G\M\T');
                $url  = parse_url($params['url']);

                $this->client->setHeader('Date', $date);
                $this->client->setHeader('Authorization', $this->signRequest('GET', $date, $url['path']));

            }

            if (isset($params['lastmodified'])) {
                $this->client->setHeader('If-Modified-Since', $params['lastmodified']);
            }

            $response = $this->client->get($params['url']);
            $body     = $response[0]->getContent();
            $headers  = null;

            if ($this->option['responseheader']) {
                $headers = $response[0]->getHeaders()->getAll();
                foreach ($headers as $key => $array) {
                    $headers[$key] = $array[0]->getValue();
                }
                $this->lastResponseHeaders = $headers;
            }

            if ($params['config']->isAuthenticationPossible() === true
                && $this->option['keys']['public'] !== null
                && $this->option['keys']['private'] !== null) {
                $this->client->setHeader('Date', false);
                $this->client->setHeader('Authorization', false);

            }

            if (isset($params['lastmodified'])) {
                $this->client->setHeader('If-Modified-Since', false);
            }
        } catch (\Exception $e) {
            throw new ClientException('Client exception catched, use getPrevious().', 0, $e);
        }

        return $this->createResponse($params['config']->isJson(), $response[0]->getStatusCode(), $body, $headers);
    }
}
