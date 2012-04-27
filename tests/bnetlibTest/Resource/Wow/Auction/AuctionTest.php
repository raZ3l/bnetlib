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

use bnetlib\Resource\Wow\Auction\Auction;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AuctionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Auction\Auction
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'auctions_data.json'
        ), true);

        $timeMap = array(
            'SHORT'     => 1,
            'MEDIUM'    => 2,
            'LONG'      => 3,
            'VERY_LONG' => 4
        );

        $data['neutral']['auctions'][0]['time'] = $timeMap[$data['neutral']['auctions'][0]['timeLeft']];

        self::$obj = new Auction();
        self::$obj->populate($data['neutral']['auctions'][0]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIsNotShort()
    {
        $this->assertFalse(self::$obj->isShort());
    }

    public function testIsNotMedium()
    {
        $this->assertFalse(self::$obj->isMedium());
    }

    public function testIsNotLong()
    {
        $this->assertFalse(self::$obj->isLong());
    }

    public function testIsVeryLong()
    {
        $this->assertTrue(self::$obj->isVeryLong());
    }

    public function testAuctionId()
    {
        $this->assertEquals(502, self::$obj->getAuctionId());
    }

    public function testItemId()
    {
        $this->assertEquals(63271, self::$obj->getItemId());
    }

    public function testOwner()
    {
        $this->assertEquals('Arthas', self::$obj->getOwner());
    }

    public function testBid()
    {
        $this->assertEquals(20000, self::$obj->getBid());
    }

    public function testBuyout()
    {
        $this->assertEquals(50000, self::$obj->getBuyout());
    }

    public function testQuantity()
    {
        $this->assertEquals(1, self::$obj->getQuantity());
    }

    public function testTimeLeft()
    {
        $this->assertEquals(4, self::$obj->getTimeLeft());
    }
}