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

use bnetlib\Resource\Wow\Character\Items;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ItemsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Items
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Items();
        self::$obj->populate($data['content']['items']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testAverageItemLevel()
    {
        $this->assertEquals(397, self::$obj->getAverageItemLevel());
    }

    public function testAverageItemLevelEquipped()
    {
        $this->assertEquals(394, self::$obj->getAverageItemLevelEquipped());
    }

    public function testHasBack()
    {
        $this->assertTrue(self::$obj->hasBack());
    }

    public function testBack()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getBack());
    }

    public function testHasChest()
    {
        $this->assertTrue(self::$obj->hasChest());
    }

    public function testChest()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getChest());
    }

    public function testHasFeet()
    {
        $this->assertTrue(self::$obj->hasFeet());
    }

    public function testFeet()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getFeet());
    }

    public function testHasFirstFinger()
    {
        $this->assertTrue(self::$obj->hasFirstFinger());
    }

    public function testFirstFinger()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getFirstFinger());
    }

    public function testHasSecondFinger()
    {
        $this->assertTrue(self::$obj->hasSecondFinger());
    }

    public function testSecondFinger()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getSecondFinger());
    }

    public function testHasHands()
    {
        $this->assertTrue(self::$obj->hasHands());
    }

    public function testHands()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getHands());
    }

    public function testHasHead()
    {
        $this->assertTrue(self::$obj->hasHead());
    }

    public function testHead()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getHead());
    }

    public function testHasLegs()
    {
        $this->assertTrue(self::$obj->hasLegs());
    }

    public function testLegs()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getLegs());
    }

    public function testHasMainHand()
    {
        $this->assertTrue(self::$obj->hasMainHand());
    }

    public function testMainHand()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getMainHand());
    }

    public function testHasOffHand()
    {
        $this->assertTrue(self::$obj->hasOffHand());
    }

    public function testOffHand()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getOffHand());
    }

    public function testHasNeck()
    {
        $this->assertTrue(self::$obj->hasNeck());
    }

    public function testNeck()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getNeck());
    }

    public function testHasRanged()
    {
        $this->assertTrue(self::$obj->hasRanged());
    }

    public function testRanged()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getRanged());
    }

    public function testHasShirt()
    {
        $this->assertTrue(self::$obj->hasShirt());
    }

    public function testShirt()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getShirt());
    }

    public function testHasShoulder()
    {
        $this->assertTrue(self::$obj->hasShoulder());
    }

    public function testShoulder()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getShoulder());
    }

    public function testHasNotTabard()
    {
        $this->assertFalse(self::$obj->hasTabard());
    }

    public function testTabard()
    {
        $this->assertNull(self::$obj->getTabard());
    }

    public function testHasFirstTrinket()
    {
        $this->assertTrue(self::$obj->hasFirstTrinket());
    }

    public function testFirstTrinket()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getFirstTrinket());
    }

    public function testHasSecondTrinket()
    {
        $this->assertTrue(self::$obj->hasSecondTrinket());
    }

    public function testSecondTrinket()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getSecondTrinket());
    }

    public function testHasWaist()
    {
        $this->assertTrue(self::$obj->hasWaist());
    }

    public function testWaist()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getWaist());
    }

    public function testHasWrist()
    {
        $this->assertTrue(self::$obj->hasWrist());
    }

    public function testWrist()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', self::$obj->getWrist());
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $item) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Item', $item);
        }
    }
}