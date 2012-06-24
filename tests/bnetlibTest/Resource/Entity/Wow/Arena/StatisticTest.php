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

namespace bnetlibTest\Resource\Entity\Wow\Arena;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Arena\Statistic;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Arena
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class StatisticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\ArenaLadder\Statistic
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/arena_ladder.json'
        ), true);

        $stats = array();
        foreach ($data['arenateam'][0]['members'][0] as $stat => $sval) {
            if ($stat === 'character') {
                continue;
            }
            $stats[$stat] = $sval;
        }

        self::$obj = new Statistic();
        self::$obj->setServiceLocator(new ServiceLocator());
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