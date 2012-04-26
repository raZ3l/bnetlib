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

namespace bnetlibTest\Resource\Wow\Shared;

use bnetlib\Resource\Wow\Shared\ArenaTeam;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class ArenaTeamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Shared\ArenaTeam
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);;

        self::$obj = new ArenaTeam();
        self::$obj->populate($data['content']['pvp']['arenaTeams'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testName()
    {
        $this->assertEquals('Lordaeron\'s Defense', self::$obj->getName());
    }

    public function testRating()
    {
        $this->assertEquals(2700, self::$obj->getRating());
    }

    public function testSize()
    {
        $this->assertEquals('5v5', self::$obj->getSize());
    }

}