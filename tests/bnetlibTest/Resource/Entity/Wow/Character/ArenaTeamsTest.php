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

namespace bnetlibTest\Resource\Entity\Wow\Character;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Character\ArenaTeams;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ArenaTeamsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\ArenaTeams
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);

        self::$obj = new ArenaTeams();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['pvp']['arenaTeams']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testCountable()
    {
        $this->assertEquals(1, count(self::$obj));
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
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\ArenaTeam', self::$obj->getTeamSize('5v5'));
    }

    public function testTeamSizeNotFound()
    {
        $this->assertNull(self::$obj->getTeamSize('2v2'));
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $team) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\ArenaTeam', $team);
            break;
        }

        $this->assertTrue($tested);
    }
}