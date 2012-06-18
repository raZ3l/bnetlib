<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @category   bnetlib
 * @package    Game
 * @subpackage UnitTests
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\Resource\Entity;

use bnetlib\Connection\Stub;
use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Entity
 * @subpackage UnitTests
 * @group      Entity
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testEntities()
    {
        $errors     = array();
        $class      = new ServiceLocator();
        $reflection = new \ReflectionClass($class);
        $services  = $reflection->getProperty('services');
        $services->setAccessible(true);
        $services  = $services->getValue($class);

        foreach ($services as $name => $service) {
            if (strpos($name, '.config.') === false) {
                try {
                    $current = $class->get($name);
                } catch (ServiceNotCreatedException $e) {
                    $errors[$service][] = 'unable to load';
                }

                if (!$current instanceof EntityInterface) {
                    $errors[$service][] = 'must implement EntityInterface';
                }
            }
        }

        if (!empty($errors)) {
            $error = '';
            foreach ($errors as $name => $list) {
                $error .= $name . ': ' . implode(', ', $list) . PHP_EOL;
            }
            $this->fail($error);
        }
    }

    public function testConfigs()
    {
        $errors     = array();
        $class      = new ServiceLocator();
        $reflection = new \ReflectionClass($class);
        $services  = $reflection->getProperty('services');
        $services->setAccessible(true);
        $services  = $services->getValue($class);

        foreach ($services as $name => $service) {
            if (strpos($name, '.config.') !== false) {
                try {
                    $current = $class->get($name);
                } catch (ServiceNotCreatedException $e) {
                    $errors[$service][] = 'unable to load';
                }

                if (!$current instanceof ConfigurationInterface) {
                    $errors[$service][] = 'must implement ConfigurationInterface';
                }
            }
        }

        if (!empty($errors)) {
            $error = '';
            foreach ($errors as $name => $list) {
                $error .= $name . ': ' . implode(', ', $list) . PHP_EOL;
            }
            $this->fail($error);
        }
    }
}