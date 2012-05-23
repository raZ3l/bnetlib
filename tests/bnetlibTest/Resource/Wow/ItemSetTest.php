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

namespace bnetlibTest\Resource\Wow;

use bnetlib\Resource\Wow\ItemSet;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_ItemSet
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ItemSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\ItemSet
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/_files/item_set_1060.json'
        ), true);

        self::$obj = new ItemSet();
        self::$obj->populate($data);
    }

    public function testId()
    {
        $this->assertEquals(1060, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('Deep Earth Vestments', self::$obj->getName());
    }

    public function testBonuses()
    {
        $this->assertInternalType('array', self::$obj->getBonuses());
    }

    public function testByThreshold()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\ItemSet\Bonus', self::$obj->getByThreshold(2));
    }

    public function testByUndefinedThreshold()
    {
        $this->assertNull(self::$obj->getByThreshold(10));
    }

    public function htestHasThreshold($threshold)
    {
        $this->assertTrue(self::$obj->hasThreshold(2));
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $bg) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\ItemSet\Bonus', $bg);
        }
    }
}