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
use bnetlib\Resource\Entity\Wow\AuctionData;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_AuctionData
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AuctionDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\AuctionData
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/auctions_data.json'
        ), true);

        self::$obj = new AuctionData();
        self::$obj->setServiceLocator(new ServiceLocator());
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
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Auction\Faction', self::$obj->getAlliance());
    }

    public function testHorde()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Auction\Faction', self::$obj->getHorde());
    }

    public function testNeutral()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Auction\Faction', self::$obj->getNeutral());
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $fac) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Auction\Faction', $fac);
            break;
        }

        $this->assertTrue($tested);
    }
}