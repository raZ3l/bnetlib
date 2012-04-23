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

use bnetlib\Resource\Wow\Character\Guild;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class GuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Guild
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);;

        self::$obj = new Guild();
        self::$obj->populate($data['content']['guild']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testCountable()
    {
        $this->assertEquals(count(self::$obj), 161);
    }

    public function testName()
    {
        $this->assertEquals(self::$obj->getName(), 'Barmy');
    }

    public function testRealm()
    {
        $this->assertEquals(self::$obj->getRealm(), 'Die ewige Wacht');
    }

    public function testLevel()
    {
        $this->assertEquals(self::$obj->getLevel(), 25);
    }

    public function testMembers()
    {
        $this->assertEquals(self::$obj->getMembers(), 161);
    }

    public function testAchievementPoints()
    {
        $this->assertEquals(self::$obj->getAchievementPoints(), 1425);
    }

    public function testEmblem()
    {
       $this->assertInternalType('array', self::$obj->getEmblem());
    }

    public function testEmblemIcon()
    {
        $this->assertEquals(self::$obj->getEmblemIcon(), 126);
    }

    public function testEmblemIconColor()
    {
        $this->assertEquals(self::$obj->getEmblemIconColor(), 'ffb1b8b1');
    }

    public function testEmblemBorder()
    {
        $this->assertEquals(self::$obj->getEmblemBorder(), 0);
    }

    public function testEmblemBorderColor()
    {
        $this->assertEquals(self::$obj->getEmblemBorderColor(), 'ff0f1415');
    }

    public function testEmblemBackgroundColor()
    {
        $this->assertEquals(self::$obj->getEmblemBackgroundColor(), 'ff232323');
    }
}