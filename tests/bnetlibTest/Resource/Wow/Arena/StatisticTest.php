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

namespace bnetlibTest\Resource\Wow\Arena;

use bnetlib\Resource\Wow\Arena\Statistic;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Arena
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class StatisticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\ArenaLadder\Statistic
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'arena_ladder.json'
        ), true);

        $stats = array();
        foreach ($data['arenateam'][0]['members'][0] as $stat => $sval) {
            if ($stat === 'character') {
                continue;
            }
            $stats[$stat] = $sval;
        }

        self::$obj = new Statistic();
        self::$obj->populate($stats);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testRank()
    {
        $this->assertEquals(0, self::$obj->getRank());
    }

    public function gePlayed()
    {
        $this->assertEquals(0, self::$obj->gePlayed());
    }

    public function testWon()
    {
        $this->assertEquals(0, self::$obj->getWon());
    }

    public function testLost()
    {
        $this->assertEquals(0, self::$obj->getLost());
    }

    public function testSessionPlayed()
    {
        $this->assertEquals(0, self::$obj->getSessionPlayed());
    }

    public function testSessionWon()
    {
        $this->assertEquals(0, self::$obj->getSessionWon());
    }

    public function testSessionLost()
    {
        $this->assertEquals(0, self::$obj->getSessionLost());
    }

    public function testRating()
    {
        $this->assertEquals(1000, self::$obj->getRating());
    }
}