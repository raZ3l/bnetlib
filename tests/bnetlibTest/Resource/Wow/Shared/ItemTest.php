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

use bnetlib\Resource\Wow\Shared\Item;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Shared\Item
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);;

        self::$obj = new Item();
        self::$obj->populate($data['content']['items']['neck']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(71472, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('Flowform Choker', self::$obj->getName());
    }

    public function testQuality()
    {
        $this->assertEquals(4, self::$obj->getQuality());
    }

    public function testIsNotPoor()
    {
        $this->assertFalse(self::$obj->isPoor());
    }

    public function testIsNotCommon()
    {
        $this->assertFalse(self::$obj->isCommon());
    }

    public function testIsNotUncommon()
    {
        $this->assertFalse(self::$obj->isUncommon());
    }

    public function testIsNotRare()
    {
        $this->assertFalse(self::$obj->isRare());
    }

    public function testIsEpic()
    {
        $this->assertTrue(self::$obj->isEpic());
    }

    public function testIsNotHeirloom()
    {
        $this->assertFalse(self::$obj->isHeirloom());
    }

    public function testIsNotArtifact()
    {
        $this->assertFalse(self::$obj->isArtifact());
    }

    public function testIsNotLegendary()
    {
        $this->assertFalse(self::$obj->isLegendary());
    }
}