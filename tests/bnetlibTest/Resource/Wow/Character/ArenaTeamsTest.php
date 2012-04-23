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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlibTest\Resource;

use bnetlib\Resource\Wow\Character\ArenaTeams;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class ArenaTeamsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\ArenaTeams
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);

        self::$obj = new ArenaTeams();
        self::$obj->populate($data['content']['pvp']['arenaTeams']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testCountable()
    {
        $this->assertEquals(count(self::$obj), 1);
    }

    public function testHasTeam()
    {
        $this->assertTrue(self::$obj->hasTeam());
    }

    public function testHasTeamSize()
    {
        $this->assertTrue(self::$obj->hasTeamSize('5v5'));
    }

    public function testHasNotTeamSize()
    {
        $this->assertFalse(self::$obj->hasTeamSize('2v2'));
    }

    public function testTeamSize()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\ArenaTeam', self::$obj->getTeamSize('5v5'));
    }

    public function testTeamSizeNotFound()
    {
        $this->assertNull(self::$obj->getTeamSize('2v2'));
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $team) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Character\ArenaTeam', $team);
        }
    }
}