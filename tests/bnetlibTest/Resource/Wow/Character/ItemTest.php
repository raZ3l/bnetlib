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

use bnetlib\Resource\Wow\Character\Item;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Item
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Item();
        self::$obj->populate($data['content']['items']['neck']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIcon()
    {
        $this->assertEquals('inv_misc_necklace_firelands_1', self::$obj->getIcon());
    }

    public function testHasTooltipParams()
    {
        $this->assertTrue(self::$obj->hasTooltipParams());
    }

    public function testTooltipParams()
    {
        $this->assertInternalType('array', self::$obj->getTooltipParams());
    }

    public function testIsNotTransmogrified()
    {
        $this->assertFalse(self::$obj->isTransmogrified());
    }

    public function testTransmogrification()
    {
        $this->assertNull(self::$obj->getTransmogrification());
    }

    public function testIsNotSetItem()
    {
        $this->assertFalse(self::$obj->isSetItem());
    }

    public function testSetItemIds()
    {
        $this->assertNull(self::$obj->getSetItemIds());
    }

    public function testIsReforged()
    {
        $this->assertTrue(self::$obj->isReforged());
    }

    public function testReforge()
    {
        $this->assertEquals('165', self::$obj->getReforge());
    }

    public function testIsNotEnchanted()
    {
        $this->assertFalse(self::$obj->isEnchanted());
    }

    public function testEnchant()
    {
        $this->assertNull(self::$obj->getEnchant());
    }

    public function testHasNotExtraSocket()
    {
        $this->assertFalse(self::$obj->hasExtraSocket());
    }
}