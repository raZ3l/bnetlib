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

use Zend\Http\Client;
use Zend\Http\Request;

/**
 * @category  bnetlib
 * @package   Game
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Connection implements ConnectionInterface
{
    /**
     * @var Zend\Http\Client
     */
    protected $client = null;

    /**
     * @var array
     */
    protected $config = array(
        'securerequests' => false,
        'responseheader'  => true,
        'keys' => array(
            'public' => null,
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
     * @param Client $client
     * @param array  $config
     */
    public function __construct(Client $client = null, array $config = null)
    {
        $this->client = ($client) ?: new Client();
        $this->client->setConfig(array(
            'useragent' => 'bnetlib/1.0.0 Zend\Http\Client (PHP/' . PHP_VERSION . ')'
        ));

        if (is_array($config)) {
            $this->setConfig($config);
        }
    }

    /**
     * @inheritdoc
     */
    public function request(array $params)
    {

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
            $this->config[$key] = (boolean) $config[$key];
        }

        if ($this->config['keys']['public'] !== null
            && $this->config['keys']['private'] !== null
            && !isset($config['securerequests'])) {
            $this->config['securerequests'] = true;
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function doSecureRequest()
    {
        return $this->config['securerequests'];
    }

    /**
     * @return Zend\Http\Client
     */
    public function getClient()
    {
        return $this->client;
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
}
