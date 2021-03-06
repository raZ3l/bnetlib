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
use bnetlib\Resource\Entity\Wow\ArenaTeam;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_ArenaTeam
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ArenaTeamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\ArenaLadder\ArenaTeam
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/arena_ladder.json'
        ), true);

        self::$obj = new ArenaTeam();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['arenateam'][0]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testRealm()
    {
        $this->assertEquals('Mannoroth', self::$obj->getRealm());
    }

    public function testRanking()
    {
        $this->assertEquals(1, self::$obj->getRanking());
    }

    public function testCreated()
    {
        $this->assertInstanceOf('DateTime', self::$obj->getCreated());
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
        $this->assertEquals(95, self::$obj->getSessionPlayed());
    }

    public function testSessionWon()
    {
        $this->assertEquals(82, self::$obj->getSessionWon());
    }

    public function testSessionLost()
    {
        $this->assertEquals(13, self::$obj->getSessionLost());
    }

    public function testFaction()
    {
        $this->assertEquals(0, self::$obj->getFaction());
    }

    public function testCurrentWeekRanking()
    {
        $this->assertEquals(0, self::$obj->getCurrentWeekRanking());
    }

    public function testLastSessionRanking()
    {
        $this->assertEquals(0, self::$obj->getLastSessionRanking());
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $team) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Arena\Character', $team);
            break;
        }

        $this->assertTrue($tested);
    }
}