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

/**
 * @category  bnetlib
 * @package   Connection
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
abstract class AbstractConnection
{
    /**
     * @var object
     */
    protected $client = null;

    /**
     * @var array
     */
    protected $config = array(
        'securerequests' => false,
        'responseheader' => true,
        'keys' => array(
            'public'  => null,
            'private' => null
        ),
        'defaults' => array(
            'region' => null,
            'locale' => array(
                self::REGION_US => null,
                self::REGION_EU => null,
                self::REGION_KR => null,
                self::REGION_TW => null,
                self::REGION_CN => null
            )
        )
    );

    /**
     * @var array|null
     */
    protected $lastResponseHeaders = null;

    /**
     * @param  string $region
     * @throws Exception\DomainException
     * @return string
     */
    public function getHost($region)
    {
        $name = 'self::HOST_' . strtoupper($region);
        if (defined($name)) {
            return constant($name);
        }

        throw new Exception\DomainException(sprintf('Unable to find a host for %s.', $region));
    }

    /**
     * @return boolean
     */
    public function doSecureRequest()
    {
        return $this->config['securerequests'];
    }

    /**
     * @return string|null
     */
    public function getDefaultRegion()
    {
        return $this->config['defaults']['region'];
    }

    /**
     * @param  string $region
     * @return string|null
     */
    public function getDefaultLocale($region)
    {
        if (isset($this->config['defaults']['locale'][$region])) {
            return $this->config['defaults']['locale'][$region];
        }

        return null;
    }

    /**
     * @param  array $config
     * @return self
     */
    public function setConfig(array $config)
    {
        if (isset($config['keys'])) {
            if (isset($config['keys']['public'])) {
                $this->config['keys']['public'] = $config['keys']['public'];
            }
            if (isset($config['keys']['private'])) {
                $this->config['keys']['private'] = $config['keys']['private'];
            }
        }
        if (isset($config['defaults'])) {
            if (isset($config['defaults']['region'])) {
                $this->config['defaults']['region'] = $config['defaults']['region'];
            }
            if (isset($config['defaults']['locale'])) {
                foreach ($config['defaults']['locale'] as $const => $default) {
                    $this->config['defaults']['locale'][$const] = $default;
                }
            }
        }
        foreach (array('securerequests', 'responseheader') as $key) {
            if (isset($config[$key])) {
                $this->config[$key] = (boolean) $config[$key];
            }
        }

        if ($this->config['keys']['public'] !== null
            && $this->config['keys']['private'] !== null
            && !isset($config['securerequests'])) {
            $this->config['securerequests'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return array|null
     */
    public function getLastResponseHeaders()
    {
        return $this->lastResponseHeaders;
    }

    /**
     * @param  boolean    $json
     * @param  int        $status
     * @param  string     $body
     * @param  array|null $headers
     * @return
     */
    protected function createResponse($json, $status, $body, $headers = null)
    {
        if ($json) {
            $body  = $this->decodeJson($body);
            $error = (isset($body['reason'])) ? $body['reason'] : '';
        } else {
            $error = 'Unkown error for non json response.';
        }

        switch ($status) {
            case 200:
                $return = array();
                $return['content'] = $body;
                $return['headers'] = $headers;

                return $return;
            case 304:
                throw new Exception\CacheException('Not modified.');
            case 400:
                $this->identifyError($error);
            case 404:
                throw new Exception\PageNotFoundException($error);
            /**
             * @see http://tools.ietf.org/html/draft-nottingham-http-new-status-04#page-4
             */
            case 429:
                throw new Exception\RequestsThrottledException('The application or IP has been throttled.');
            case 500:
                $this->identifyError($error);
            default:
                throw new Exception\UnexpectedResponseException(sprintf(
                    'Unexpected status code returned (%s).', $status
                ));
        }
    }

    /**
     * @see    http://blizzard.github.com/api-wow-docs/#id3379854
     * @param  string $method
     * @param  string $path
     * @return string
     */
    protected function signRequest($method, $date, $path)
    {
        $sign = sprintf("%s\n%s\n%s\n", $method, $date, $path);
        $hash = base64_encode(hash_hmac('sha1', $sign, $this->config['keys']['private'], true));

        return sprintf('BNET %s:%s', $this->config['keys']['public'], $hash);
    }

    /**
     * @param  string $json
     * @return array
     */
    protected function decodeJson($json)
    {
        $json = json_decode($json, true);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $json;
            case JSON_ERROR_DEPTH:
                throw new Exception\JsonException('The maximum stack depth has been exceeded.');
            case JSON_ERROR_STATE_MISMATCH:
                throw new Exception\JsonException('Underflow or the modes mismatch.');
            case JSON_ERROR_CTRL_CHAR:
                throw new Exception\JsonException('Unexpected control character found.');
            case JSON_ERROR_SYNTAX:
                throw new Exception\JsonException('Syntax error, malformed JSON.');
            case JSON_ERROR_UTF8:
                throw new Exception\JsonException('Malformed UTF-8 characters, possibly incorrectly encoded.');
        }
    }

    /**
     * @param  string $reason
     * @return string
     */
    protected function identifyError($reason)
    {
        /**
         * Reasons = tl;dr so we will be using md5 hashes to identify errors.
         */
        $hash = md5($reason);
        switch ($hash) {
            /**
             * If at first you don't succeed, blow it up again. (too many requests)
             */
            case '6aa100ae58ed694e80ef45901f17734b':
                $exception = 'bnetlib\Exception\RequestsThrottledException';
                $reason    = 'The application or IP has been throttled.';
                break;
            /**
             * Access denied, please contact api-support@blizzard.com
             */
            case '911fd139b916543848180092cbfa48da':
                $exception = 'bnetlib\Exception\RequestBlockedException';
                $reason    = 'The application or IP address has been blocked from making '
                             . 'further requests. This ban may not be permanent.';
                break;
            /**
             * Have you not been through enough? Will you continue to fight what you cannot defeat?
             * (something unexpected happened)
             */
            case '347edf2b3e1b7a05c857fe5853fe0125':
                $exception = 'bnetlib\Exception\ServerErrorException';
                $reason    = 'There was a server error or equally catastrophic exception '
                             . 'preventing the request from being fulfilled.';
                break;
            /**
             * Invalid authentication header.
             */
            case '3db241e10bf80bce93d1f166c660bbf3':
                $exception = 'bnetlib\Exception\InvalidAuthHeaderException';
                $reason    = 'The application authorization information was mallformed or missing when expected.';
                break;
            /**
             * Invalid application signature.
             */
            case '61ddc9bdef5d29b179cd1328f3661f6c':
                $exception = 'bnetlib\Exception\InvalidAppSignatureException';
                $reason    = 'The application request signature was missing or invalid. This will also be thrown'
                             . ' if the request date outside of a 15 second window from the current GMT time.';
                break;
            /**
             * Invalid Application
             */
            case '3212017d5cdbe9d9794d22a22a0e4476':
                $exception = 'bnetlib\Exception\InvalidAppException';
                $reason    = 'A request was made including application identification information, but either '
                             . 'the application key is invalid or missing.';
                break;
            /**
             * Invalid application permissions.
             */
            case '39b90417e5c7dba18a96eef9ddb62992':
                $exception = 'bnetlib\Exception\InvalidAppPermissionsException';
                $reason    = 'A request was made to an API resource that requires a higher application '
                             . 'permission level.';
                break;
            default:
                $exception = 'bnetlib\Exception\UnexpectedResponseException';
                break;
        }

        throw new $exception($reason);
    }
}
