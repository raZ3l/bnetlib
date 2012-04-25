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

namespace bnetlibTest\Resource\Wow\Character;

use bnetlib\Resource\Wow\Character\RatedBattlegrounds;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class RatedBattlegroundsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\RatedBattlegrounds
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);;

        self::$obj = new RatedBattlegrounds();
        self::$obj->populate($data['content']['pvp']['ratedBattlegrounds']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testPersonalRating()
    {
        $this->assertEquals(0, self::$obj->getPersonalRating());
    }

    public function testHattlegrounds()
    {
        $this->assertInternalType('array', self::$obj->getBattlegrounds());
    }

    public function testHins()
    {
        $this->assertEquals(4, self::$obj->getWins());
    }

    public function testHosses()
    {
        $this->assertEquals(3, self::$obj->getLosses());
    }

    public function testHlayed()
    {
        $this->assertEquals(7, self::$obj->getPlayed());
    }

    public function testHasPlayed()
    {
        $this->assertTrue(self::$obj->hasPlayed());
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $rbg) {
            $this->assertInternalType('array', $rbg);
        }
    }
}