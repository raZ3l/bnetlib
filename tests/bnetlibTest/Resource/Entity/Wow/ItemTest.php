<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
 *
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\Resource\Entity\Wow;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Item;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Item
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Item
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/fixtures/item_38268.json'), true);

        self::$obj = new Item();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testDisenchantingSkillRank()
    {
        $this->assertEquals(-1, self::$obj->getDisenchantingSkillRank());
    }

    public function testDescription()
    {
        $this->assertEquals('Give to a Friend', self::$obj->getDescription());
    }

    public function testName()
    {
        $this->assertEquals('Spare Hand', self::$obj->getName());
    }

    public function testStacksize()
    {
        $this->assertEquals(1, self::$obj->getStacksize());
    }

    public function testIsNotStackable()
    {
        $this->assertFalse(self::$obj->isStackable());
    }

    public function testItemBind()
    {
        $this->assertEquals(0, self::$obj->getItemBind());
    }

    public function testHasClassRestriction()
    {
        $this->assertTrue(self::$obj->hasClassRestriction());
    }

    public function testAllowableClasses()
    {
         $this->assertInstanceOf('bnetlib\Resource\Entity\Shared\ListData', self::$obj->getAllowableClasses());
    }

    public function testHasRaceRestriction()
    {
        $this->assertTrue(self::$obj->hasRaceRestriction());
    }

    public function testAllowableRacees()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Shared\ListData', self::$obj->getAllowableRacees());
    }

    public function testIsNotBindable()
    {
        $this->assertFalse(self::$obj->isBindable());
    }

    public function testIsNotBoundOnPickUp()
    {
        $this->assertFalse(self::$obj->isBoundOnPickUp());
    }

    public function testIsNotBoundOnEquip()
    {
        $this->assertFalse(self::$obj->isBoundOnEquip());
    }

    public function testIsNotBoundOnUse()
    {
        $this->assertFalse(self::$obj->isBoundOnUse());
    }

    public function testHasBonusStats()
    {
        $this->assertTrue(self::$obj->hasBonusStats());
    }

    public function testBonusStats()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Item\BonusStats', self::$obj->getBonusStats());
    }

    public function testHasItemSpells()
    {
        $this->assertTrue(self::$obj->hasItemSpells());
    }

    public function testItemSpells()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Item\Spells', self::$obj->getItemSpells());
    }

    public function testBuyPrice()
    {
        $this->assertEquals(12, self::$obj->getBuyPrice());
    }

    public function testItemClass()
    {
        $this->assertEquals(2, self::$obj->getItemClass());
    }

    public function testItemSubClass()
    {
        $this->assertEquals(14, self::$obj->getItemSubClass());
    }

    public function testContainerSlots()
    {
        $this->assertEquals(0, self::$obj->getContainerSlots());
    }

    public function testHasWeaponInfo()
    {
        $this->assertTrue(self::$obj->hasWeaponInfo());
    }

    public function testWeaponInfo()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Item\WeaponInfo', self::$obj->getWeaponInfo());
    }

    public function testInventoryType()
    {
        $this->assertEquals(13, self::$obj->getInventoryType());
    }

    public function testIsEquippable()
    {
        $this->assertTrue(self::$obj->isEquippable());
    }

    public function testItemLevel()
    {
        $this->assertEquals(1, self::$obj->getItemLevel());
    }

    public function testItemSet()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\ItemSet', self::$obj->getItemSet());
    }

    public function testIsNotUnique()
    {
        $this->assertFalse(self::$obj->isUnique());
    }

    public function testUniqueCount()
    {
        $this->assertEquals(0, self::$obj->getUniqueCount());
    }

    public function testDurability()
    {
        $this->assertEquals(16, self::$obj->getDurability());
    }

    public function testHasNoFactionRequirement()
    {
        $this->assertFalse(self::$obj->hasFactionRequirement());
    }

    public function testRequiredFactionId()
    {
        $this->assertEquals(0, self::$obj->getRequiredFactionId());
    }

    public function testHasNoReputationRequirement()
    {
        $this->assertFalse(self::$obj->hasReputationRequirement());
    }

    public function testRequiredStanding()
    {
        $this->assertEquals(0, self::$obj->getRequiredStanding());
    }

    public function testSellPrice()
    {
        $this->assertEquals(2, self::$obj->getSellPrice());
    }

    public function testHasLevelRequirement()
    {
        $this->assertTrue(self::$obj->hasLevelRequirement());
    }

    public function testRequiredLevel()
    {
        $this->assertEquals(70, self::$obj->getRequiredLevel());
    }

    public function testHasProfessionRequirement()
    {
        $this->assertTrue(self::$obj->hasProfessionRequirement());
    }

    public function testRequiredProfession()
    {
        $this->assertEquals(0, self::$obj->getRequiredProfession());
    }

    public function testHasNoProfessionRankRequirement()
    {
        $this->assertFalse(self::$obj->hasProfessionRankRequirement());
    }

    public function testRequiredProfessionRank()
    {
        $this->assertEquals(0, self::$obj->getRequiredProfessionRank());
    }

    public function testItemSource()
    {
        $this->assertInternalType('array', self::$obj->getItemSource());
    }

    public function testHasSockets()
    {
        $this->assertTrue(self::$obj->hasSockets());
    }

    public function testSocketInfo()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Item\SocketInfo', self::$obj->getSocketInfo());
    }

    public function testIsAuctionable()
    {
        $this->assertTrue(self::$obj->isAuctionable());
    }

    public function testBaseArmor()
    {
        $this->assertEquals(0, self::$obj->getBaseArmor());
    }

    public function testArmor()
    {
        $this->assertEquals(0, self::$obj->getArmor());
    }
}