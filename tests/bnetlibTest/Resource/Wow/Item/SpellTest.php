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

namespace bnetlibTest\Resource\Wow\Item;

use bnetlib\Resource\Wow\Item\Spell;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Item
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class SpellTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Item\Spell
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'item_38268.json'
        ), true);

        self::$obj = new Spell();
        self::$obj->populate($data['itemSpells'][0]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(107082, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('Embrace of the Destroyer', self::$obj->getName());
    }

    public function testIcon()
    {
        $this->assertEquals('inv_misc_head_dragon_black', self::$obj->getIcon());
    }

    public function testDescription()
    {
        $this->assertEquals('Slows your falling speed for 15 sec.', self::$obj->getDescription());
    }

    public function testHasPowerCost()
    {
        $this->assertTrue(self::$obj->hasPowerCost());
    }

    public function testPowerCost()
    {
        $this->assertEquals(
            'com.blizzard.battlenet.wow.spell.model.SpellPowerCost@47b10c56',
            self::$obj->getPowerCost()
        );
    }

    public function testHasCastTime()
    {
        $this->assertTrue(self::$obj->hasCastTime());
    }

    public function testCastTime()
    {
        $this->assertEquals('Instant cast', self::$obj->getCastTime());
    }

    public function testHasCooldown()
    {
        $this->assertTrue(self::$obj->hasCooldown());
    }

    public function testCooldown()
    {
        $this->assertEquals('1 min cooldown', self::$obj->getCooldown());
    }

    public function testHasNoCharges()
    {
        $this->assertFalse(self::$obj->hasCharges());
    }

    public function testCharges()
    {
        $this->assertEquals(0, self::$obj->getCharges());
    }

    public function testIsNotConsumable()
    {
        $this->assertFalse(self::$obj->isConsumable());
    }

    public function testCategoryId()
    {
        $this->assertEquals(1335, self::$obj->getCategoryId());
    }

    public function testTrigger()
    {
        $this->assertEquals('ON_EQUIP', self::$obj->getTrigger());
    }
}