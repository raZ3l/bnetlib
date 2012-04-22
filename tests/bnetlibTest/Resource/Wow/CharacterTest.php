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
    protected $character;

    public function setUp()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);

        $this->character = new Character();
        $this->character->populate($data);
    }

    public function tearDown()
    {
        unset($this->character);
    }

    public function testName()
    {
        $this->assertEquals($this->character->getName(), 'Coss');
    }

    public function testRealm()
    {
        $this->assertEquals($this->character->getRealm(), 'Die ewige Wacht');
    }

    public function testLastModified()
    {
        $this->assertEquals($this->character->getLastModified(), 1333377686000);
    }

    public function testThumbnail()
    {
        $this->assertEquals($this->character->getThumbnail(), 'die-ewige-wacht/157/60753821-avatar.jpg');
    }

    public function testLevel()
    {
        $this->assertEquals($this->character->getLevel(), 85);
    }

    public function testClass()
    {
        $this->assertEquals($this->character->getClass(), 8);
    }

    public function testRace()
    {
        $this->assertEquals($this->character->getRace(), 7);
    }

    public function testGender()
    {
        $this->assertEquals($this->character->getGender(), 0);
    }

    public function testFaction()
    {
        $this->assertEquals($this->character->getFaction(), 0);
    }

    public function testAchievementPoints()
    {
        $this->assertEquals($this->character->getAchievementPoints(), 10420);
    }

    public function testAchievementsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\Achievements', $this->character->getAchievements());
    }

    public function testAppearanceField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Appearance', $this->character->getAppearance());
    }

    public function testCompanionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', $this->character->getCompanions());
    }

    public function testGuildField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Guild', $this->character->getGuild());
    }

    public function testItemsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Items', $this->character->getItems());
    }

    public function testMountsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', $this->character->getMounts());
    }

    public function testPetsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Pets', $this->character->getPets());
    }

    public function testProfessionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Professions', $this->character->getProfessions());
    }

    public function testProgressionField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Progression', $this->character->getProgression());
    }

    public function testPvpField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Pvp', $this->character->getPvp());
    }

    public function testQuestsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', $this->character->getQuests());
    }

    public function testReputationField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Reputation', $this->character->getReputation());
    }

    public function testStatsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Stats', $this->character->getStats());
    }

    public function testTalentsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Talents', $this->character->getTalents());
    }

    public function testTitlesField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Titles', $this->character->getTitles());
    }

    public function testIsMale()
    {
        $this->assertTrue($this->character->isMale());
    }

    public function testIsNotFemale()
    {
        $this->assertFalse($this->character->isFemale());
    }

    public function testIsAlliance()
    {
        $this->assertTrue($this->character->isAlliance());
    }

    public function testIsNotHorde()
    {
        $this->assertFalse($this->character->isHorde());
    }

    public function testIsGnome()
    {
        $this->assertTrue($this->character->isGnome());
    }

    public function testIsNotOtherRace()
    {
        $this->assertFalse($this->character->isHuman());
        $this->assertFalse($this->character->isOrc());
        $this->assertFalse($this->character->isHorde());
        $this->assertFalse($this->character->isDwarf());
        $this->assertFalse($this->character->isNightElf());
        $this->assertFalse($this->character->isUndead());
        $this->assertFalse($this->character->isTauren());
        $this->assertFalse($this->character->isTroll());
        $this->assertFalse($this->character->isGoblin());
        $this->assertFalse($this->character->isBloodElf());
        $this->assertFalse($this->character->isDraenei());
        $this->assertFalse($this->character->isWorgen());
    }

    public function testIsMage()
    {
        $this->assertTrue($this->character->isMage());
    }

    public function testIsNotOtherClass()
    {
        $this->assertFalse($this->character->isWarrior());
        $this->assertFalse($this->character->isPaladin());
        $this->assertFalse($this->character->isHunter());
        $this->assertFalse($this->character->isRogue());
        $this->assertFalse($this->character->isPriest());
        $this->assertFalse($this->character->isDeathKnight());
        $this->assertFalse($this->character->isShaman());
        $this->assertFalse($this->character->isWarlock());
        $this->assertFalse($this->character->isDruid());
    }
}