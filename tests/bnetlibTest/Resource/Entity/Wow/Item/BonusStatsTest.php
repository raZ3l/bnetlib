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

namespace bnetlibTest\Resource\Entity\Wow\Item;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Item\BonusStats;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Item
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class BonusStatsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Item\BonusStats
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/item_38268.json'
        ), true);

        self::$obj = new BonusStats();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['bonusStats']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testByStat()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Item\Stat', self::$obj->getByStat(3));
    }

    public function testHasNotStat()
    {
        $this->assertFalse(self::$obj->hasStat(666));
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $bg) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Item\Stat', $bg);
            break;
        }

        $this->assertTrue($tested);
    }
}