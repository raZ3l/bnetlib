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
use bnetlib\Resource\Entity\Wow\Character\Profession;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ProfessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Profession
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Profession();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['professions']['primary'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(171, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('Alchemy', self::$obj->getName());
    }

    public function testIcon()
    {
        $this->assertEquals('trade_alchemy', self::$obj->getIcon());
    }

    public function testRank()
    {
        $this->assertEquals(525, self::$obj->getRank());
    }

    public function testMaxRank()
    {
        $this->assertEquals(525, self::$obj->getMaxRank());
    }

    public function testRecipes()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Shared\ListData', self::$obj->getRecipes());
    }

    public function testKnowsRecipe()
    {
        $this->assertTrue(self::$obj->knowsRecipe('2329'));
    }

    public function testDontKnowsRecipe()
    {
        $this->assertFalse(self::$obj->knowsRecipe('12345'));
    }

    public function testIsAlchimist()
    {
        $this->assertTrue(self::$obj->isAlchimist());
    }

    public function testIsNotBlacksmith()
    {
        $this->assertFalse(self::$obj->isBlacksmith());
    }

    public function testIsNotEnchanter()
    {
        $this->assertFalse(self::$obj->isEnchanter());
    }

    public function testIsNotEngineer()
    {
        $this->assertFalse(self::$obj->isEngineer());
    }

    public function testIsNotHerbalist()
    {
        $this->assertFalse(self::$obj->isHerbalist());
    }

    public function testIsNotScribe()
    {
        $this->assertFalse(self::$obj->isScribe());
    }

    public function testIsNotJewelcrafter()
    {
        $this->assertFalse(self::$obj->isJewelcrafter());
    }

    public function testIsNotLeatherworker()
    {
        $this->assertFalse(self::$obj->isLeatherworker());
    }

    public function testIsNotMiner()
    {
        $this->assertFalse(self::$obj->isMiner());
    }

    public function testIsNotSkinner()
    {
        $this->assertFalse(self::$obj->isSkinner());
    }

    public function testIsNotTailor()
    {
        $this->assertFalse(self::$obj->isTailor());
    }

    public function testIsNotFirstAider()
    {
        $this->assertFalse(self::$obj->isFirstAider());
    }

    public function testIsNotArchaeologist()
    {
        $this->assertFalse(self::$obj->isArchaeologist());
    }

    public function testIsNotFisher()
    {
        $this->assertFalse(self::$obj->isFisher());
    }
    public function testIsNotCook()
    {
        $this->assertFalse(self::$obj->isCook());
    }

    public function testIsPrimaryProfession()
    {
        $this->assertTrue(self::$obj->isPrimaryProfession());
    }

    public function testIsNotSecondaryProfession()
    {
        $this->assertFalse(self::$obj->isSecondaryProfession());
    }

    public function testIsNotGatherProfession()
    {
        $this->assertFalse(self::$obj->isGatherProfession());
    }
}