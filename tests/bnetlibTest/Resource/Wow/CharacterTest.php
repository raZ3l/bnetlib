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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlibTest\Resource;

use bnetlib\Resource\Wow\Character;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class CharacterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);

        self::$obj = new Character();
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testName()
    {
        $this->assertEquals(self::$obj->getName(), 'Coss');
    }

    public function testRealm()
    {
        $this->assertEquals(self::$obj->getRealm(), 'Die ewige Wacht');
    }

    public function testLastModified()
    {
        $this->assertEquals(self::$obj->getLastModified(), 1333377686000);
    }

    public function testThumbnail()
    {
        $this->assertEquals(self::$obj->getThumbnail(), 'die-ewige-wacht/157/60753821-avatar.jpg');
    }

    public function testLevel()
    {
        $this->assertEquals(self::$obj->getLevel(), 85);
    }

    public function testClass()
    {
        $this->assertEquals(self::$obj->getClass(), 8);
    }

    public function testRace()
    {
        $this->assertEquals(self::$obj->getRace(), 7);
    }

    public function testGender()
    {
        $this->assertEquals(self::$obj->getGender(), 0);
    }

    public function testFaction()
    {
        $this->assertEquals(self::$obj->getFaction(), 0);
    }

    public function testAchievementPoints()
    {
        $this->assertEquals(self::$obj->getAchievementPoints(), 10420);
    }

    public function testAchievementsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\Achievements', self::$obj->getAchievements());
    }

    public function testAppearanceField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Appearance', self::$obj->getAppearance());
    }

    public function testCompanionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', self::$obj->getCompanions());
    }

    public function testGuildField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Guild', self::$obj->getGuild());
    }

    public function testItemsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Items', self::$obj->getItems());
    }

    public function testMountsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', self::$obj->getMounts());
    }

    public function testPetsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Pets', self::$obj->getPets());
    }

    public function testProfessionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Professions', self::$obj->getProfessions());
    }

    public function testProgressionField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Progression', self::$obj->getProgression());
    }

    public function testPvpField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Pvp', self::$obj->getPvp());
    }

    public function testQuestsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', self::$obj->getQuests());
    }

    public function testReputationField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Reputation', self::$obj->getReputation());
    }

    public function testStatsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Stats', self::$obj->getStats());
    }

    public function testTalentsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Talents', self::$obj->getTalents());
    }

    public function testTitlesField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Titles', self::$obj->getTitles());
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