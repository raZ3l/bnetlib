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
 * @package    Resource
 * @subpackage UnitTests
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\Resource\Wow\Realms;

use bnetlib\Resource\Wow\Realms\PvpArea;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Realms
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class PvpAreaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Realms\PvpArea
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/_files/realms.json'
        ), true);

        self::$obj = new PvpArea();
        self::$obj->populate($data['realms'][0]['wintergrasp']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testArea()
    {
        $this->assertEquals(1, self::$obj->getArea());
    }

    public function testControllingFaction()
    {
        $this->assertEquals(0, self::$obj->getControllingFaction());
    }

    public function testIsAllianceControlled()
    {
        $this->assertTrue(self::$obj->isAllianceControlled());
    }

    public function testIsNotHordeControlled()
    {
        $this->assertFalse(self::$obj->isHordeControlled());
    }

    public function testStatus()
    {
        $this->assertEquals(2, self::$obj->getStatus());
    }

    public function testStatusString()
    {
        $this->assertEquals('Active', self::$obj->getStatusString());
    }

    public function testIsNotIdle()
    {
        $this->assertFalse(self::$obj->isIdle());
    }

    public function testIsNotPopulating()
    {
        $this->assertFalse(self::$obj->isPopulating());
    }

    public function testIsActive()
    {
        $this->assertTrue(self::$obj->isActive());
    }

    public function testIsNotConcluded()
    {
        $this->assertFalse(self::$obj->isConcluded());
    }

    public function testNext()
    {
        $this->assertEquals(1336426680668, self::$obj->getNext());
    }
}