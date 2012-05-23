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

namespace bnetlibTest\Resource\Wow\Guild;

use bnetlib\Resource\Wow\Guild\NewsEntry;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Guild
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class NewsEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Guild\NewsEntry
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/_files/guild.json'
        ), true);;

        self::$obj = new NewsEntry();
        self::$obj->populate($data['news'][4]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testType()
    {
        $this->assertEquals('guildAchievement', self::$obj->getType());
    }

    public function testTimestamp()
    {
        $this->assertEquals('1335394380000', self::$obj->getTimestamp());
    }

    public function testAchievement()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Achievements\DataAchievement', self::$obj->getAchievement());
    }

    public function testCharacter()
    {
        $this->assertEquals('Dustin', self::$obj->getCharacter());
    }

    public function testItemId()
    {
        $this->assertNull(self::$obj->getItemId());
    }

    public function testLevelUp()
    {
        $this->assertNull(self::$obj->getLevelUp());
    }

    public function testIsNotItemType()
    {
        $this->assertFalse(self::$obj->isItemType());
    }

    public function testIsGuildType()
    {
        $this->assertTrue(self::$obj->isGuildType());
    }

    public function testIsNotPlayerType()
    {
        $this->assertFalse(self::$obj->isPlayerType());
    }
}