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
use bnetlib\Resource\Entity\Wow\Character;

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
     * @var bnetlib\Resource\Entity\Wow\Character
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/character.json'
        ), true);

        self::$obj = new Character();
        self::$obj->setServiceLocator(new ServiceLocator());
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
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Achievements\Achievements', self::$obj->getAchievements());
    }

    public function testAppearanceField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Appearance', self::$obj->getAppearance());
    }

    public function testCompanionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Shared\ListData', self::$obj->getCompanions());
    }

    public function testGuildField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Guild', self::$obj->getGuild());
    }

    public function testItemsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Items', self::$obj->getItems());
    }

    public function testMountsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Shared\ListData', self::$obj->getMounts());
    }

    public function testFeedField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Feed', self::$obj->getFeed());
    }

    public function testPetsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Pets', self::$obj->getPets());
    }

    public function testProfessionsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Professions', self::$obj->getProfessions());
    }

    public function testProgressionField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Progression', self::$obj->getProgression());
    }

    public function testPvpField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Pvp', self::$obj->getPvp());
    }

    public function testQuestsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Shared\ListData', self::$obj->getQuests());
    }

    public function testReputationField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Reputation', self::$obj->getReputation());
    }

    public function testStatsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Stats', self::$obj->getStats());
    }

    public function testTalentsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Talents', self::$obj->getTalents());
    }

    public function testTitlesField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Titles', self::$obj->getTitles());
    }

    public function testFullName()
    {
        $this->assertEquals('Coss the Insane', self::$obj->getFullName());
    }
}