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

use bnetlib\WorldOfWarcraft;

/**
 * @category   bnetlib
 * @package    Game
 * @subpackage UnitTests
 * @group      Game
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class WorldOfWarcraftTest extends \PHPUnit_Framework_TestCase
{
    protected static $resources;

    public static function setUpBeforeClass()
    {
        $wow         = new WorldOfWarcraft();
        $reflection  = new \ReflectionClass($wow);
        $resources = $reflection->getProperty('resources');
        $resources->setAccessible(true);
        self::$resources = $resources->getValue($wow);
    }

    public static function tearDownAfterClass()
    {
        self::$resources = null;
    }

    public function testResources()
    {
        $errors = array();

        foreach (self::$resources as $resource => $array) {
            foreach (array('class', 'config') as $key) {
                if (!isset($array[$key])) {
                    $errors[$resource][] = $key . ' key missing';
                } elseif (!class_exists($array[$key], true)) {
                    $errors[$resource][] = $key . ' not found';
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