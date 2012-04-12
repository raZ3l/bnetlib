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
     * @param  array $resources
     * @throws Exception\DomainException
     * @return self
     */
    public function setResource(array $resources)
    {
        foreach ($resources as $name => $data) {
            if (isset($this->resources[$name])) {
                $this->resources[$name] = $data;
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

    }
}
