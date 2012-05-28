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

use bnetlib\Exception\JsonException;
use bnetlib\Exception\CacheException;
use bnetlib\Exception\DomainException;
use bnetlib\Exception\PageNotFoundException;
use bnetlib\Exception\RequestsThrottledException;
use bnetlib\Exception\ServerUnavailableException;
use bnetlib\Exception\UnexpectedResponseException;

/**
 * @category  bnetlib
 * @package   Connection
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * @var object
     */
    protected $client = null;

    /**
     * @var array
     */
    protected $option = array(
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
     * @throws DomainException
     * @return string
     */
    public function getHost($region)
    {
        $name = 'self::HOST_' . strtoupper($region);
        if (defined($name)) {
            return constant($name);
        }

        throw new DomainException(sprintf('Unable to find a host for %s.', $region));
    }

    /**
     * @return boolean
     */
    public function doSecureRequest()
    {
        return $this->option['securerequests'];
    }

    /**
     * @return string|null
     */
    public function getDefaultRegion()
    {
        return $this->option['defaults']['region'];
    }

    /**
     * @param  string $region
     * @return string|null
     */
    public function getDefaultLocale($region)
    {
        if (isset($this->option['defaults']['locale'][$region])) {
            return $this->option['defaults']['locale'][$region];
        }

        return null;
    }

    /**
     * @param  array $option
     * @return self
     */
    public function setOptions(array $option)
    {
        if (isset($option['keys'])) {
            if (isset($option['keys']['public'])) {
                $this->option['keys']['public'] = $option['keys']['public'];
            }
            if (isset($option['keys']['private'])) {
                $this->option['keys']['private'] = $option['keys']['private'];
            }
        }
        if (isset($option['defaults'])) {
            if (isset($option['defaults']['region'])) {
                $this->option['defaults']['region'] = $option['defaults']['region'];
            }
            if (isset($option['defaults']['locale'])) {
                foreach ($option['defaults']['locale'] as $const => $default) {
                    $this->option['defaults']['locale'][$const] = $default;
                }
            }
        }
        foreach (array('securerequests', 'responseheader') as $key) {
            if (isset($option[$key])) {
                $this->option[$key] = (boolean) $option[$key];
            }
        }

        if ($this->option['keys']['public'] !== null
            && $this->option['keys']['private'] !== null
            && !isset($option['securerequests'])) {
            $this->option['securerequests'] = true;
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
     * @return array
     */
    protected function createResponse($json, $status, $body, $headers = null)
    {
        if ($json) {
            $body  = $this->decodeJson($body);
            $error = (isset($body['reason'])) ? $body['reason'] : '';
        } else {
            $error = 'Unkown error for non JSON response.';
        }

        switch ($status) {
            case 200:
                $return = array();
                $return['content'] = $body;
                $return['headers'] = $headers;

                return $return;
            case 304:
                throw new CacheException('Not modified.', $status);
            case 400:
                $this->identifyError($error, $status);
            case 404:
                throw new PageNotFoundException($error, $status);
            case 429:
                throw new RequestsThrottledException('The application or IP has been throttled.', $status);
            case 500:
                $this->identifyError($error, $status);
            case 503:
                throw new ServerUnavailableException('The server is currently unavailable.', $status);
            default:
                throw new UnexpectedResponseException(
                    sprintf('Unexpected status code returned (%s).', $status),
                    $status
                );
        }
    }

    /**
     * @see    http://blizzard.github.com/api-wow-docs/#id3379854
     * @param  string $method
     * @param  string $date
     * @param  string $path
     * @return string
     */
    protected function signRequest($method, $date, $path)
    {
        $sign = sprintf("%s\n%s\n%s\n", $method, $date, $path);
        $hash = base64_encode(hash_hmac('sha1', $sign, $this->option['keys']['private'], true));

        return sprintf('BNET %s:%s', $this->option['keys']['public'], $hash);
    }

    /**
     * @param  string $json
     * @throws JsonException Wrapper for json_last_error()
     * @return array
     */
    protected function decodeJson($json)
    {
        $json = json_decode($json, true);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $json;
            case JSON_ERROR_DEPTH:
                throw new JsonException('The maximum stack depth has been exceeded.');
            case JSON_ERROR_STATE_MISMATCH:
                throw new JsonException('Underflow or the modes mismatch.');
            case JSON_ERROR_CTRL_CHAR:
                throw new JsonException('Unexpected control character found.');
            case JSON_ERROR_SYNTAX:
                throw new JsonException('Syntax error, malformed JSON.');
            case JSON_ERROR_UTF8:
                throw new JsonException('Malformed UTF-8 characters, possibly incorrectly encoded.');
        }
    }

    /**
     * @param  string $reason
     * @param  int    $status
     */
    protected function identifyError($reason, $status)
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
             *
             * Internal server error.
             */
            case '347edf2b3e1b7a05c857fe5853fe0125':
            case '12f61df7baf5ed8af20b15c3bd04d056':
                $exception = 'bnetlib\Exception\ServerErrorException';
                $reason    = 'There was a server error preventing the request from being fulfilled.';
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
                $reason    = 'You\'ve request an API resource that requires a higher application permission level.';
                break;
            default:
                $exception = 'bnetlib\Exception\UnknownErrorException';
                break;
        }

        throw new $exception($reason, $status);
    }
}
