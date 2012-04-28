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

namespace bnetlibTest\Resource\Wow\Item;

use bnetlib\Resource\Wow\Item\BonusStats;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Item
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class BonusStatsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Item\BonusStats
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'item_38268.json'
        ), true);

        self::$obj = new BonusStats();
        self::$obj->populate($data['bonusStats']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testByStat()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Item\Stat', self::$obj->getByStat(3));
    }

    public function testHasNotStat()
    {
        $this->assertFalse(self::$obj->hasStat(666));
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $bg) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Item\Stat', $bg);
        }
    }
}