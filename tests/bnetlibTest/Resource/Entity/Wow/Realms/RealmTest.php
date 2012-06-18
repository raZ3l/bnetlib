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

namespace bnetlibTest\Resource\Entity\Wow\Realms;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Realms\Realm;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Realms
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RealmTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Realms\Realm
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/realms.json'
        ), true);

        self::$obj = new Realm();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['realms'][2]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testType()
    {
        $this->assertEquals('rppvp', self::$obj->getType());
    }

    public function testPopulation()
    {
        $this->assertEquals('low', self::$obj->getPopulation());
    }

    public function testQueue()
    {
        $this->assertFalse(self::$obj->getQueue());
    }

    public function testStatus()
    {
        $this->assertTrue(self::$obj->getStatus());
    }

    public function testName()
    {
        $this->assertEquals('Agamaggan', self::$obj->getName());
    }

    public function testSlug()
    {
        $this->assertEquals('agamaggan', self::$obj->getSlug());
    }

    public function testBattlegroup()
    {
        $this->assertEquals('Blackout', self::$obj->getBattlegroup());
    }

    public function testWintergrasp()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Realms\PvpArea', self::$obj->getWintergrasp());
    }

    public function testTolBarad()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Realms\PvpArea', self::$obj->getTolBarad());
    }

    public function testIsNotPvpRealm()
    {
        $this->assertFalse(self::$obj->isPvpRealm());
    }

    public function testIsNotPveRealm()
    {
        $this->assertFalse(self::$obj->isPveRealm());
    }

    public function testIsRpPvpRealm()
    {
        $this->assertTrue(self::$obj->isRpPvpRealm());
    }

    public function testIsNotRpPveRealm()
    {
        $this->assertFalse(self::$obj->isRpPveRealm());
    }

    public function testIsRpRealm()
    {
        $this->assertTrue(self::$obj->isRpRealm());
    }

    public function testIsLowlyPopulated()
    {
        $this->assertTrue(self::$obj->isLowlyPopulated());
    }

    public function testIsNotMediumPopulated()
    {
        $this->assertFalse(self::$obj->isMediumPopulated());
    }

    public function testIsNotHighlyPopulated()
    {
        $this->assertFalse(self::$obj->isHighlyPopulated());
    }

    public function testIsOnline()
    {
        $this->assertTrue(self::$obj->isOnline());
    }

    public function testHasQueue()
    {
        $this->assertFalse(self::$obj->hasQueue());
    }
}