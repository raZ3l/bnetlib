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
use bnetlib\Resource\Entity\Wow\Character\Record;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_RatedBattlegroundLadder
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RecordTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Record
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/rbg_ladder.json'
        ), true);

        self::$obj = new Record();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['bgRecord'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testRank()
    {
        $this->assertEquals(1, self::$obj->getRank());
    }

    public function testRating()
    {
        $this->assertEquals(3959, self::$obj->getRating());
    }

    public function testWins()
    {
        $this->assertEquals(21, self::$obj->getWins());
    }

    public function testPlayed()
    {
        $this->assertEquals(24, self::$obj->getPlayed());
    }

    public function testLosses()
    {
        $this->assertEquals(3, self::$obj->getLosses());
    }

    public function testLastModified()
    {
        $this->assertEquals(1334733776000, self::$obj->getLastModified());
    }

    public function testRealm()
    {
        $this->assertEquals('Stormscale', self::$obj->getRealm());
    }

    public function testRealmSlug()
    {
        $this->assertEquals('stormscale', self::$obj->getRealmSlug());
    }

    public function testBattlegroup()
    {
        $this->assertEquals('Cyclone / Wirbelsturm', self::$obj->getBattlegroup());
    }

    public function testBattlegroupSlug()
    {
        $this->assertEquals('cyclone-wirbelsturm', self::$obj->getBattlegroupSlug());
    }

    public function testCharacter()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character', self::$obj->getCharacter());
    }
}