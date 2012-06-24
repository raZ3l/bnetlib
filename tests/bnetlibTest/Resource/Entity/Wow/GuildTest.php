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
use bnetlib\Resource\Entity\Wow\Guild;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Guild
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class GuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Guild
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/guild.json'
        ), true);

        self::$obj = new Guild();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testLastModified()
    {
        $this->assertEquals(1334261125000, self::$obj->getLastModified());
    }

    public function testName()
    {
        $this->assertEquals('Barmy', self::$obj->getName());
    }

    public function testRealm()
    {
        $this->assertEquals('Die ewige Wacht', self::$obj->getRealm());
    }

    public function testLevel()
    {
        $this->assertEquals(25, self::$obj->getLevel());
    }

    public function testFaction()
    {
        $this->assertEquals(0, self::$obj->getFaction());
    }

    public function testAchievementPoints()
    {
        $this->assertEquals(1425, self::$obj->getAchievementPoints());
    }

    public function testNewsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Guild\News', self::$obj->getNews());
    }

    public function testMembersField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Guild\Members', self::$obj->getMembers());
    }

    public function testAchievementsField()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Achievements\Achievements', self::$obj->getAchievements());
    }
}