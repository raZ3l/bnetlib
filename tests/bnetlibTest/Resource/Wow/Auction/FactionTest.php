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

namespace bnetlibTest\Resource\Wow\Auction;

use bnetlib\Resource\Wow\Auction\Faction;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class FactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Auction\Faction
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/auctions_data.json'
        ), true);

        self::$obj = new Faction();
        self::$obj->populate($data['neutral']['auctions']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testByItem()
    {
        $this->assertEquals(18, count(self::$obj->getByItem(63271)));
    }

    public function testItemIndex()
    {
        $this->assertEquals(2, count(self::$obj->getItemIndex()));
    }

    public function testByTime()
    {
        $this->assertEquals(8, count(self::$obj->getByTime(Faction::TIME_VERY_LONG)));
    }

    public function testByTimeWithString()
    {
        $this->assertEquals(8, count(self::$obj->getByTime('VERY_LONG')));
    }

    /**
     * @expectedException bnetlib\Exception\InvalidArgumentException
     */
    public function testByTimeWithInvalidName()
    {
        self::$obj->getByTime('INVALID_NAME');
    }

    /**
     * @expectedException bnetlib\Exception\InvalidArgumentException
     */
    public function testByTimeWithInvalidType()
    {
       self::$obj->getByTime(true);
    }

    public function testTimeIndex()
    {
        $this->assertEquals(4, count(self::$obj->getTimeIndex()));
    }

    public function testItemAndTimeIntersection()
    {
        $this->assertEquals(1, count(self::$obj->getItemAndTimeIntersection(63277, Faction::TIME_VERY_LONG)));
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $fac) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Auction\Auction', $fac);
        }
    }
}