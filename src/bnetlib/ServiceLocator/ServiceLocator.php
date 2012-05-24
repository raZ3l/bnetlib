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
 * @package   ServiceLocator
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\ServiceLocator;

use bnetlib\Exception\InvalidServiceNameException;

/**
 * @category  bnetlib
 * @package   ServiceLocator
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ServiceLocator implements ServiceLocatorInterface
{
    /**
     * @var array
     */
    $shared = array();

    /**
     * @var array
     */
    $services = array();

    /**
     * @param  string  $name
     * @param  boolean $shared
     * @throws bnetlib\Exception\InvalidServiceNameException
     * @return object
     */
    public function get($name, $shared = false)
    {
        if (!isset($this->services[$name])) {
            throw new ServiceNotCreatedException(sprintf('Unable to fetch or create an instance for %s.', $name);
        }

        if ($shared === true && isset($this->shared[$name])) {
            return $this->shared[$name];
        }

        $instance = new $this->services[$name]();

        if ($shared === true) {
            $this->shared[$name] = $instance;
        }

        return $instance;
    }
}