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

namespace bnetlibTest\Resource\Wow\Character;

use bnetlib\Resource\Wow\Character\Faction;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class FactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Faction
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/_files/character.json'
        ), true);

        self::$obj = new Faction();
        self::$obj->populate($data['content']['reputation'][0]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(1098, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('Knights of the Ebon Blade', self::$obj->getName());
    }

    public function testStanding()
    {
        $this->assertEquals(7, self::$obj->getStanding());
    }

    public function testValue()
    {
        $this->assertEquals(999, self::$obj->getValue());
    }

    public function testMax()
    {
        $this->assertEquals(999, self::$obj->getMax());
    }

    public function testIsAtMax()
    {
        $this->assertTrue(self::$obj->isAtMax());
    }

    public function testIsExalted()
    {
        $this->assertTrue(self::$obj->isExalted());
    }

    public function testIsRevered()
    {
        $this->assertFalse(self::$obj->isRevered());
    }

    public function testIsHonored()
    {
        $this->assertFalse(self::$obj->isHonored());
    }

    public function testIsFriendly()
    {
        $this->assertFalse(self::$obj->isFriendly());
    }

    public function testIsNeutral()
    {
        $this->assertFalse(self::$obj->isNeutral());
    }

    public function testIsUnfriendly()
    {
        $this->assertFalse(self::$obj->isUnfriendly());
    }

    public function testIsHostile()
    {
        $this->assertFalse(self::$obj->isHostile());
    }

    public function testIsHated()
    {
        $this->assertFalse(self::$obj->isHated());
    }
}