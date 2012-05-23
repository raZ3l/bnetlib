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

namespace bnetlibTest\Resource\Wow\Character;

use bnetlib\Resource\Wow\Character\Stats;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class StatsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Stats
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/_files/character.json'
        ), true);;

        self::$obj = new Stats();
        self::$obj->populate($data['content']['stats']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testHealth()
    {
        $this->assertEquals(138829, self::$obj->getHealth());
    }

    public function testPowerType()
    {
        $this->assertEquals('mana', self::$obj->getPowerType());
    }

    public function testPower()
    {
        $this->assertEquals(123977, self::$obj->getPower());
    }

    public function testStrength()
    {
        $this->assertEquals(52, self::$obj->getStrength());
    }

    public function testAgility()
    {
        $this->assertEquals(68, self::$obj->getAgility());
    }

    public function testStamina()
    {
        $this->assertEquals(7284, self::$obj->getStamina());
    }

    public function testIntellect()
    {
        $this->assertEquals(6729, self::$obj->getIntellect());
    }

    public function testSpirit()
    {
        $this->assertEquals(210, self::$obj->getSpirit());
    }

    public function testAttackPower()
    {
        $this->assertEquals(42, self::$obj->getAttackPower());
    }

    public function testRangedAttackPower()
    {
        $this->assertEquals(0, self::$obj->getRangedAttackPower());
    }

    public function testMastery()
    {
        $this->assertEquals(13.661533, self::$obj->getMastery());
    }

    public function testMasteryRating()
    {
        $this->assertEquals(1015, self::$obj->getMasteryRating());
    }

    public function testCrit()
    {
        $this->assertEquals(12.696494, self::$obj->getCrit());
    }

    public function testCritRating()
    {
        $this->assertEquals(1596, self::$obj->getCritRating());
    }

    public function testHit()
    {
        $this->assertEquals(14.636729, self::$obj->getHit());
    }

    public function testHitRating()
    {
        $this->assertEquals(1758, self::$obj->getHitRating());
    }

    public function testHasteRating()
    {
        $this->assertEquals(1381, self::$obj->getHasteRating());
    }

    public function testExpertiseRating()
    {
        $this->assertEquals(0, self::$obj->getExpertiseRating());
    }

    public function testSpellPower()
    {
        $this->assertEquals(9664, self::$obj->getSpellPower());
    }

    public function testSpellPenetration()
    {
        $this->assertEquals(0, self::$obj->getSpellPenetration());
    }

    public function testSpellCrit()
    {
        $this->assertEquals(23.179499, self::$obj->getSpellCrit());
    }

    public function testSpellCritRating()
    {
        $this->assertEquals(1596, self::$obj->getSpellCritRating());
    }

    public function testSpellHit()
    {
        $this->assertEquals(17.160303, self::$obj->getSpellHit());
    }

    public function testSpellHitRating()
    {
        $this->assertEquals(1758, self::$obj->getSpellHitRating());
    }

    public function testMpFive()
    {
        $this->assertEquals(1159, self::$obj->getMpFive());
    }

    public function testMpFiveInCombat()
    {
        $this->assertEquals(869, self::$obj->getMpFiveInCombat());
    }

    public function testArmor()
    {
        $this->assertEquals(9435, self::$obj->getArmor());
    }

    public function testDodge()
    {
        $this->assertEquals(3.685666, self::$obj->getDodge());
    }

    public function testDodgeRating()
    {
        $this->assertEquals(0, self::$obj->getDodgeRating());
    }

    public function testParry()
    {
        $this->assertEquals(0, self::$obj->getParry());
    }

    public function testParryRating()
    {
        $this->assertEquals(0, self::$obj->getParryRating());
    }

    public function testBlock()
    {
        $this->assertEquals(0, self::$obj->getBlock());
    }

    public function testBlockRating()
    {
        $this->assertEquals(0, self::$obj->getBlockRating());
    }

    public function testResilience()
    {
        $this->assertEquals(0, self::$obj->getResilience());
    }

    public function testMainHandDmgMin()
    {
        $this->assertEquals(370, self::$obj->getMainHandDmgMin());
    }

    public function testMainHandDmgMax()
    {
        $this->assertEquals(684, self::$obj->getMainHandDmgMax());
    }

    public function testMainHandSpeed()
    {
        $this->assertEquals(1.354, self::$obj->getMainHandSpeed());
    }

    public function testMainHandDps()
    {
        $this->assertEquals(389.1102, self::$obj->getMainHandDps());
    }

    public function testMainHandExpertise()
    {
        $this->assertEquals(3, self::$obj->getMainHandExpertise());
    }

    public function testOffHandDmgMin()
    {
        $this->assertEquals(0, self::$obj->getOffHandDmgMin());
    }

    public function testOffHandDmgMax()
    {
        $this->assertEquals(0, self::$obj->getOffHandDmgMax());
    }

    public function testOffHandSpeed()
    {
        $this->assertEquals(1.805, self::$obj->getOffHandSpeed());
    }

    public function testOffHandDps()
    {
        $this->assertEquals(0, self::$obj->getOffHandDps());
    }

    public function testOffHandExpertise()
    {
        $this->assertEquals(0, self::$obj->getOffHandExpertise());
    }

    public function testRangedDmgMin()
    {
        $this->assertEquals(1581, self::$obj->getRangedDmgMin());
    }

    public function testRangedDmgMax()
    {
        $this->assertEquals(2937, self::$obj->getRangedDmgMax());
    }

    public function testRangedSpeed()
    {
        $this->assertEquals(1.625, self::$obj->getRangedSpeed());
    }

    public function testRangedDps()
    {
        $this->assertEquals(1390.2698, self::$obj->getRangedDps());
    }

    public function testRangedCrit()
    {
        $this->assertEquals(12.696494, self::$obj->getRangedCrit());
    }

    public function testRangedCritRating()
    {
        $this->assertEquals(1596, self::$obj->getRangedCritRating());
    }

    public function testRangedHit()
    {
        $this->assertEquals(14.636729, self::$obj->getRangedHit());
    }

    public function testRangedHitRating()
    {
        $this->assertEquals(1758, self::$obj->getRangedHitRating());
    }
}