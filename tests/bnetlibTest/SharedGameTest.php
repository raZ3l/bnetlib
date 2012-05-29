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

namespace bnetlibTest;

use bnetlib\Exception\ServiceNotCreatedException;

/**
 * @category   bnetlib
 * @package    Game
 * @subpackage UnitTests
 * @group      Game
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
abstract class SharedGameTest extends \PHPUnit_Framework_TestCase
{
    protected static $game;

    public static function tearDownAfterClass()
    {
        self::$game = null;
    }

    public function testShortName()
    {
        if (defined(get_class(self::$game) . '::SHORT_NAME')) {
            $this->assertTrue(true);
        } else {
            $this->fail('A Game must have SHORT_NAME definded.');
        }
    }

    /**
     * @depends testShortName
     */
    public function testResources()
    {
        $errors     = array();
        $reflection = new \ReflectionClass(self::$game);
        $resources  = $reflection->getProperty('resources');
        $resources->setAccessible(true);
        $resources  = $resources->getValue(self::$game);
        $classname  = get_class(self::$game);

        foreach ($resources as $resource => $service) {
            foreach (array('service', 'config') as $key) {
                $entry = ($key === 'config')
                    ? sprintf('%s.config.%s', constant($classname . '::SHORT_NAME'), strtolower($resource))
                    : $service;
                if (!self::$game->getServiceLocator()->has($entry)) {
                    $errors[$resource][] = $key . ' not found';
                }
                if ($key === 'service') {
                    try {
                        self::$game->getServiceLocator()->get($entry);
                    } catch (InvalidServiceNameException $e) {
                        $errors[$resource][] = 'unable to find service '. $key;
                    } catch (ServiceNotCreatedException $e) {
                        $errors[$resource][] = 'unable to load service '. $key;
                    }
                }
            }
        }

        if (!empty($errors)) {
            $error = '';
            foreach ($errors as $resource => $value) {
                $error .= $resource . ': ' . implode(', ', $value) . ' ';
            }
            $this->fail($error);
        }

        $this->assertTrue(true);
    }
}