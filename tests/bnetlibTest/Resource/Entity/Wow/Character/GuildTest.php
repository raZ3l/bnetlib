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

namespace bnetlibTest\Resource\Entity\Wow\Character;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Character\Guild;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class GuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Guild
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Guild();
        self::$obj->setServiceLocator(new ServiceLocator());
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

    public function testMembers()
    {
        $this->assertEquals(161, self::$obj->getMembers());
    }

    public function testAchievementPoints()
    {
        $this->assertEquals(1425, self::$obj->getAchievementPoints());
    }

    public function testEmblemIcon()
    {
        $this->assertEquals(126, self::$obj->getEmblemIcon());
    }

    public function testEmblemIconColor()
    {
        $this->assertEquals('ffb1b8b1', self::$obj->getEmblemIconColor());
    }

    public function testEmblemBorder()
    {
        $this->assertEquals(0, self::$obj->getEmblemBorder());
    }

    public function testEmblemBorderColor()
    {
        $this->assertEquals('ff0f1415', self::$obj->getEmblemBorderColor());
    }

    public function testEmblemBackgroundColor()
    {
        $this->assertEquals('ff232323', self::$obj->getEmblemBackgroundColor());
    }
}