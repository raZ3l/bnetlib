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
    protected $obj;

    public function setUp()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);

        $this->obj = new Character();
        $this->obj->populate($data);
    }

    public function tearDown()
    {
        unset($this->obj);
    }

    public function testName()
    {
        $this->assertEquals($this->obj->getName(), 'Coss');
    }

    public function testRealm()
    {
        $this->assertEquals($this->obj->getRealm(), 'Die ewige Wacht');
    }

    public function testLastModified()
    {
        $this->assertEquals($this->obj->getLastModified(), 1333377686000);
    }

    public function testThumbnail()
    {
        $this->assertEquals($this->obj->getThumbnail(), 'die-ewige-wacht/157/60753821-avatar.jpg');
    }

    public function testLevel()
    {
        $this->assertEquals($this->obj->getLevel(), 85);
    }

    public function testClass()
    {
        $this->assertEquals($this->obj->getClass(), 8);
    }

    public function testRace()
    {
        $this->assertEquals($this->obj->getRace(), 7);
    }

    public function testGender()
    {
        $this->assertEquals($this->obj->getGender(), 0);
    }

    public function testFaction()
    {
        $this->assertEquals($this->obj->getFaction(), 0);
    }

    public function testAchievementPoints()
    {
        $this->assertEquals($this->obj->getAchievementPoints(), 10420);
    }

    public function testAchievementsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\Achievements', $this->obj->getAchievements());
    }

    public function testAppearanceField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Appearance', $this->obj->getAppearance());
    }

    public function testCompanionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', $this->obj->getCompanions());
    }

    public function testGuildField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Guild', $this->obj->getGuild());
    }

    public function testItemsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Items', $this->obj->getItems());
    }

    public function testMountsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', $this->obj->getMounts());
    }

    public function testPetsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Pets', $this->obj->getPets());
    }

    public function testProfessionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Professions', $this->obj->getProfessions());
    }

    public function testProgressionField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Progression', $this->obj->getProgression());
    }

    public function testPvpField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Pvp', $this->obj->getPvp());
    }

    public function testQuestsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', $this->obj->getQuests());
    }

    public function testReputationField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Reputation', $this->obj->getReputation());
    }

    public function testStatsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Stats', $this->obj->getStats());
    }

    public function testTalentsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Talents', $this->obj->getTalents());
    }

    public function testTitlesField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Titles', $this->obj->getTitles());
    }

    public function testIsMale()
    {
        $this->assertTrue($this->obj->isMale());
    }

    public function testIsNotFemale()
    {
        $this->assertFalse($this->obj->isFemale());
    }

    public function testIsAlliance()
    {
        $this->assertTrue($this->obj->isAlliance());
    }

    public function testIsNotHorde()
    {
        $this->assertFalse($this->obj->isHorde());
    }

    public function testIsGnome()
    {
        $this->assertTrue($this->obj->isGnome());
    }

    public function testIsNotOtherRace()
    {
        $this->assertFalse($this->obj->isHuman());
        $this->assertFalse($this->obj->isOrc());
        $this->assertFalse($this->obj->isHorde());
        $this->assertFalse($this->obj->isDwarf());
        $this->assertFalse($this->obj->isNightElf());
        $this->assertFalse($this->obj->isUndead());
        $this->assertFalse($this->obj->isTauren());
        $this->assertFalse($this->obj->isTroll());
        $this->assertFalse($this->obj->isGoblin());
        $this->assertFalse($this->obj->isBloodElf());
        $this->assertFalse($this->obj->isDraenei());
        $this->assertFalse($this->obj->isWorgen());
    }

    public function testIsMage()
    {
        $this->assertTrue($this->obj->isMage());
    }

    public function testIsNotOtherClass()
    {
        $this->assertFalse($this->obj->isWarrior());
        $this->assertFalse($this->obj->isPaladin());
        $this->assertFalse($this->obj->isHunter());
        $this->assertFalse($this->obj->isRogue());
        $this->assertFalse($this->obj->isPriest());
        $this->assertFalse($this->obj->isDeathKnight());
        $this->assertFalse($this->obj->isShaman());
        $this->assertFalse($this->obj->isWarlock());
        $this->assertFalse($this->obj->isDruid());
    }
}