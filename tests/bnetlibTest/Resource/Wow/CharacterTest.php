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

namespace bnetlibTest\Resource\Wow;

use bnetlib\Resource\Wow\Character;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
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
            __DIR__ . '/_files/character.json'
        ), true);

        self::$obj = new Character();
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testLastModified()
    {
        $this->assertEquals(1333377686000, self::$obj->getLastModified());
    }

    public function testAchievementsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Achievements\Achievements', self::$obj->getAchievements());
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

    public function testFeedField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Feed', self::$obj->getFeed());
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
}