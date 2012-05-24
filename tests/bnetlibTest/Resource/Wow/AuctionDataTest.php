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

use bnetlib\Resource\Wow\AuctionData;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_AuctionData
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AuctionDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\AuctionData
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/auctions_data.json'
        ), true);

        self::$obj = new AuctionData();
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testRealm()
    {
        $this->assertEquals('Medivh', self::$obj->getRealm());
    }

    public function testSlug()
    {
        $this->assertEquals('medivh', self::$obj->getSlug());
    }

    public function testAlliance()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Auction\Faction', self::$obj->getAlliance());
    }

    public function testHorde()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Auction\Faction', self::$obj->getHorde());
    }

    public function testNeutral()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Auction\Faction', self::$obj->getNeutral());
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $fac) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Auction\Faction', $fac);
        }
    }
}