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

namespace bnetlibTest\Resource\Entity\Wow;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Auction;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Auction
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AuctionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Auction
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/auctions.json'
        ), true);

        self::$obj = new Auction();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testUrl()
    {
        $this->assertEquals(
            'http://us.battle.net/auction-data/medivh/auctions-1311362443895.json.gz',
            self::$obj->getUrl()
        );
    }

    public function testLastModified()
    {
        $this->assertEquals(1311362443895, self::$obj->getLastModified());
    }
}