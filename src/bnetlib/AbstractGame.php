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
 * @package   Game
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib;

use bnetlib\Resource\UtilizeInterface;
use bnetlib\Resource\ResourceInterface;
use bnetlib\Resource\ConfigurationInterface;

/**
 * @category  bnetlib
 * @package   Game
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
abstract class AbstractGame
{
    /**#@+
     * @const string
     */
    const ERROR_RESOURCE_NOT_FOUND = 'There is no resource namend %s.';
    const ERROR_MSSING_ARGUMENT    = 'Unable to fulfill your request. No %s given.';
    const ERROR_INVALID_CONFIG     = 'Invalid configuration detected for resource %s.';
    /**#@-*/

    /**#@+
     * @const int
     */
    const RETURN_PLAIN  = 1;
    const RETURN_OBJECT = 2;
    /**#@-*/

    /**
     * @var array
     */
    protected $locale = array();

    /**
     * @var Connectable
     */
    protected $connection = null;

    /**
     * @var array
     */
    protected $resources = array();

    /**
     * @var array
     */
    protected $configInstances = array();

    /**
     * @var int
     */
    protected $returnType = self::RETURN_OBJECT;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection = null)
    {
        $this->connection = ($connection) ?: new Connection();
    }

    /**
     * @return Connectable
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param  int|const $region
     * @return array|null
     */
    public function getSupportedLocale($region)
    {
        if (isset($this->locale[$region])) {
            return $this->locale[$region];
        }

        return null;
    }

    /**
     * @param  int $type
     * @return self
     */
    public function setReturnType($type)
    {
        $this->returnType = $type;

        return $this;
    }

    /**
     * @param  string $resource
     * @throws Exception\DomainException
     * @throws Exception\DomainException
     * @return object
     */
    public function getResourceConfig($resource)
    {
        if (!isset($this->resources[$resource])) {
            throw new Exception\DomainException(sprintf(self::ERROR_RESOURCE_NOT_FOUND, $resource));
        }
        if (!isset($this->configInstances[$resource])) {
            $this->configInstances[$resource] = new $this->resources[$resource]['config'];

            if (!$this->configInstances[$resource] instanceof ConfigurationInterface) {
                throw new Exception\DomainException(sprintf(
                    'Resource configuration for %s must implement ConfigurationInterface.', $resource
                ));
            }
        }

        return $this->configInstances[$resource];
    }

    /**
     * @param  array $resources
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return self
     */
    public function setResource(array $resources)
    {
        foreach ($resources as $name => $data) {
            if (isset($this->resources[$name])) {
                if (is_array($data)) {
                    if (isset($data['class'])) {
                        $this->resources[$name]['class'] = $data['class'];
                    }
                    if (isset($data['config'])) {
                        unset($this->configInstances[$name]);
                        $this->resources[$name]['config'] = $data['config'];
                    }
                } elseif (is_string($data)) {
                    $this->resources[$name]['class'] = $data;
                } else {
                    throw new Exception\InvalidArgumentException (sprintf(
                        '%n must be an array or string, %s given.', $name, gettype($data)
                    ));
                }
            } else {
                throw new Exception\DomainException(sprintf(self::ERROR_RESOURCE_NOT_FOUND, $name));
            }
        }

        return $this;
    }

    /**
     * @param  string $name
     * @param  array  $arguments
     * @return string|object
     */
    public function __call($name, $arguments)
    {
        $args   = array();
        $count  = count($args);
        $name   = substr($name, 3);

        if (!isset($this->resources[$name])) {
            throw new Exception\BadMethodCallException(
                sprintf(self::ERROR_RESOURCE_NOT_FOUND, $name)
            );
        }
        if ($count > 2) {
            throw new Exception\LengthException(sprintf(
                'Too many arguments passed. 2 or less expected, %i given.', $count
            ));
        }
        foreach ($arguments as $num => $arg) {

            if (is_array($arg)) {
                $args = array_merge($args, $arg);
            } elseif (is_string($arg)) {
                $args['url'] = $arg;
            } elseif ($arg instanceof UtilizeInterface) {
                foreach ($arg->getArguments() as $key => $value) {
                    if (!isset($args[$key])) {
                        $args[$key] = $value;
                    }
                }
            } else {
                $errType = gettype($arg);
                $errType = ($errType === 'object') ? get_class($closure) : $errType;
                throw new Exception\InvalidArgumentException(sprintf(
                    'Argument %i must be an array or implement UtilizeInterface, %s given.', $num, $errType
                ));
            }
        }

        $config         = $this->getResourceConfig($name);
        $type           = $config->getResourceType();
        $authenticate   = $config->isAuthenticationPossible();
        $lastModified   = (isset($args['lastmodified'])) ? $args['lastmodified'] : null;
        $returnType     = (isset($args['return'])) ? $args['return'] : $this->returnType;

        /**
         * Note: DATE_RFC1123 my not be RFC 1123 compliant, depending on your platform.
         * @see http://www.php.net/manual/de/function.gmdate.php#25031
         */
        $lastModified = (is_numeric($lastModified)) ? gmdate('D, d M Y H:i:s \G\M\T', $lastModified) : $lastModified;

        if ($returnType !== self::RETURN_PLAIN && $returnType !== self::RETURN_OBJECT) {
            throw new Exception\DomainException('Invalid return type specified.');
        }

        if ($type !== ConfigurationInterface::TYPE_STATIC_URL) {
            if (!isset($args['region'])) {
                $defaultRegion = $this->connection->getDefaultRegion();
                if ($defaultRegion !== null) {
                    $args['region'] = $defaultRegion;
                }
            }
            if (!isset($args['locale']) && isset($args['region'])) {
                $defaultLocale = $this->connection->getDefaultLocale($args['region']);
                if ($defaultLocale !== null) {
                    $args['locale'] = $defaultLocale;
                }
            }
        }

        switch ($type) {
            case ConfigurationInterface::TYPE_STATIC_URL:
                if (!isset($args['url'])) {
                    throw new Exception\BadMethodCallException(sprintf(self::ERROR_MSSING_ARGUMENT, 'url'));
                }
                $url = $args['url'];
                /**
                 * Necessary, because the URL returned from /api/wow/auction/data/$realm
                 * will use http as scheme, instead of https, when requested via https.
                 * Note: I'm unable to test this behavior for authenticated requests.
                 */
                if ($authenticate === true && $this->connection->doSecureRequest() === true) {
                    /**
                     * dafuq! str_replace without $limit parameter... I'm disappointed!
                     * @see https://bugs.php.net/bug.php?id=11457
                     */
                    $url = preg_replace('/^http:/', 'https:', $url);
                }
                break;
            case ConfigurationInterface::TYPE_STATIC_PATH:
            case ConfigurationInterface::TYPE_DYNAMIC_URL:
            case ConfigurationInterface::TYPE_DYNAMIC_PATH:
                $url = $this->_buildUrl($config, $args, $name);
                break;

            default:
                throw new Exception\DomainException(sprintf(
                    '%s Resource type is not valid.', sprintf(self::ERROR_INVALID_CONFIG, $name)
                ));
                break;
        }

        $response = $this->connection->request(array(
            'url'          => $url,
            'authenticate' => $authenticate,
            'lastmodified' => $lastModified
        ));

        switch ($returnType) {
            case self::RETURN_OBJECT:
                $class = new $this->resources[$name]['class'];
                if (!$class instanceof ResourceInterface) {
                    throw new Exception\DomainException(sprintf(
                        'Resource %s must implement ResourceInterface', $name
                    ));
                }
                $class->populate(json_decode($response['content'], true));
                if (isset($response['headers'])) {
                    $class->setResponseHeaders((object) $response['headers']);
                }
                return $class;
            case self::RETURN_PLAIN:
                return $response;
        }
    }


    /**
     * @param  ConfigurationInterface $config
     * @param  array                  $args
     * @param  string                 $name
     * @return string
     */
    protected function _buildUrl($config, $args, $name)
    {
        $missing  = array();
        $query    = array();
        $replace  = array();
        $type     = $config->getResourceType();
        $aliases  = $config->getArgumentAliases();
        $required = $config->getRequiredArguments();
        $optional = $config->getOptionalArguments();
        $closures = $config->getManipulableArguments();
        $secure   = $this->connection->doSecureRequest();
        $url      = ($secure === true) ? 'https://' : 'http://';

        if ($required === null
            && ($type === ConfigurationInterface::TYPE_DYNAMIC_URL
                || $type === ConfigurationInterface::TYPE_DYNAMIC_PATH)) {
            throw new Exception\InvalidArgumentException('Dynamic URLs must at least require one argument.');
        }

        if (!isset($args['region']) && $type !== ConfigurationInterface::TYPE_DYNAMIC_URL) {
            $missing[] = 'region';
        }
        if (isset($args['locale'])) {
            $query['locale'] = $args['locale'];
        }

        if (is_array($closures)) {
            foreach ($closures as $name => $closure) {
                if (isset($args[$name])) {
                    $args[$name] = $closure($args[$name]);
                }
            }
        }

        if (is_array($optional)) {
            foreach ($optional as $key) {
                if (isset($args[$key])) {
                    $query[$key] = $args[$key];
                } elseif (isset($aliases[$key])) {
                    if (is_array($aliases[$key])) {
                        foreach ($aliases[$key] as $alias) {
                            if (isset($args[$alias])) {
                                $query[$key] = $args[$alias];
                                break;
                            }
                        }
                    } elseif (is_string($aliases[$key])) {
                        if (isset($args[$aliases[$key]])) {
                            $query[$key] = $args[$aliases[$key]];
                        }
                    } else {
                        throw new Exception\InvalidArgumentException(sprintf(
                            '%s Alias for %s must be an array or string, %s given.',
                            sprintf(self::ERROR_INVALID_CONFIG, $name),
                            $key,
                            gettype($aliases[$key])
                        ));
                    }
                }
            }
        }

        if (is_array($required)) {
            foreach ($required as $key) {
                if (isset($args[$key])) {
                    $replace[] = $args[$key];
                } elseif (isset($aliases[$key])) {
                    if (is_array($aliases[$key])) {
                        $found = false;
                        foreach ($aliases[$key] as $alias) {
                            if (isset($args[$alias])) {
                                $found     = true;
                                $replace[] = $args[$alias];
                                break;
                            }
                        }
                        if ($found === false) {
                            $missing[] = $key;
                        }
                    } elseif (is_string($aliases[$key])) {
                        if (isset($args[$aliases[$key]])) {
                            $replace[] = $args[$aliases[$key]];
                        } else {
                            $missing[] = $key;
                        }
                    } else {
                        throw new Exception\InvalidArgumentException(sprintf(
                            '%s Alias for %s must be an array or string, %s given.',
                            sprintf(self::ERROR_INVALID_CONFIG, $name),
                            $key,
                            gettype($aliases[$key])
                        ));
                    }
                } else {
                    $missing[] = $key;
                }
            }
        }

        if (!empty($missing)) {
            throw new Exception\BadMethodCallException(sprintf(self::ERROR_MSSING_ARGUMENT, implode(', ', $missing)));
        }

        $query = http_build_query($query, '', '&');
        $query = ($query === '') ? $query : '?' . $query;

        if ($type !== ConfigurationInterface::TYPE_DYNAMIC_URL) {
            $url .= $this->connection->getHost($args['region']);
        }

        switch ($type) {
            case ConfigurationInterface::TYPE_DYNAMIC_URL:
            case ConfigurationInterface::TYPE_DYNAMIC_PATH:
                $url .= vsprintf($config::RESOURCE_URL, $replace);
                break;
            case ConfigurationInterface::TYPE_STATIC_PATH:
                $url .= $config::RESOURCE_URL;
                break;
        }

        $url .= $query;

        return $url;
    }
}
