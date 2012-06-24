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

namespace bnetlibTest\Resource\Entity\Wow\Shared;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Shared\Item;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Shared\Item
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Item();
        self::$obj->setServiceLocator(new ServiceLocator());
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