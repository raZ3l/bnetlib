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

namespace bnetlibTest\Resource\Entity\Wow\Shared;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Shared\Character;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class CharacterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Shared\Character
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);

        self::$obj = new Character();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testName()
    {
        $this->assertEquals('Coss', self::$obj->getName());
    }

    public function testRealm()
    {
        $this->assertEquals('Die ewige Wacht', self::$obj->getRealm());
    }

    public function testThumbnail()
    {
        $this->assertEquals('die-ewige-wacht/157/60753821-avatar.jpg', self::$obj->getThumbnail());
    }

    public function testLevel()
    {
        $this->assertEquals(85, self::$obj->getLevel());
    }

    public function testClass()
    {
        $this->assertEquals(8, self::$obj->getClass());
    }

    public function testRace()
    {
        $this->assertEquals(7, self::$obj->getRace());
    }

    public function testGender()
    {
        $this->assertEquals(0, self::$obj->getGender());
    }

    public function testFaction()
    {
        $this->assertEquals(0, self::$obj->getFaction());
    }

    public function testAchievementPoints()
    {
        $this->assertEquals(10420, self::$obj->getAchievementPoints());
    }

    public function testIsMale()
    {
        $this->assertTrue(self::$obj->isMale());
    }

    public function testIsNotFemale()
    {
        $this->assertFalse(self::$obj->isFemale());
    }

    public function testIsAlliance()
    {
        $this->assertTrue(self::$obj->isAlliance());
    }

    public function testIsNotHorde()
    {
        $this->assertFalse(self::$obj->isHorde());
    }

    public function testIsGnome()
    {
        $this->assertTrue(self::$obj->isGnome());
    }

    public function testIsNotHuman()
    {
        $this->assertFalse(self::$obj->isHuman());
    }

    public function testIsNotOrc()
    {
        $this->assertFalse(self::$obj->isOrc());
    }

    public function testIsNotDwarf()
    {
        $this->assertFalse(self::$obj->isDwarf());
    }

    public function testIsNotNightElf()
    {
        $this->assertFalse(self::$obj->isNightElf());
    }

    public function testIsNotUndead()
    {
        $this->assertFalse(self::$obj->isUndead());
    }

    public function testIsNotTauren()
    {
        $this->assertFalse(self::$obj->isTauren());
    }

    public function testIsNotTroll()
    {
        $this->assertFalse(self::$obj->isTroll());
    }

    public function testIsNotGoblin()
    {
        $this->assertFalse(self::$obj->isGoblin());
    }

    public function testIsNotBloodElf()
    {
        $this->assertFalse(self::$obj->isBloodElf());
    }

    public function testIsNotDraenei()
    {
        $this->assertFalse(self::$obj->isDraenei());
    }

    public function testIsNotWorgen()
    {
        $this->assertFalse(self::$obj->isWorgen());
    }

    public function testIsMage()
    {
        $this->assertTrue(self::$obj->isMage());
    }

    public function testIsNotWarrior()
    {
        $this->assertFalse(self::$obj->isWarrior());
    }

    public function testIsNotPaladin()
    {
        $this->assertFalse(self::$obj->isPaladin());
    }

    public function testIsNotHunter()
    {
        $this->assertFalse(self::$obj->isHunter());
    }

    public function testIsNotRogue()
    {
        $this->assertFalse(self::$obj->isRogue());
    }

    public function testIsNotPriest()
    {
        $this->assertFalse(self::$obj->isPriest());
    }

    public function testIsNotDeathKnight()
    {
        $this->assertFalse(self::$obj->isDeathKnight());
    }

    public function testIsNotWarlock()
    {
        $this->assertFalse(self::$obj->isWarlock());
    }

    public function testIsNotDruid()
    {
        $this->assertFalse(self::$obj->isDruid());
    }
}