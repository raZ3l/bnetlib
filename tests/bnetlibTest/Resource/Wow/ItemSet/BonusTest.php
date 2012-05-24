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

use bnetlib\Resource\Wow\ItemSet\Bonus;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_ItemSet
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class BonusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\ItemSet\Bonus
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/item_set_1060.json'
        ), true);

        self::$obj = new Bonus();
        self::$obj->populate($data['setBonuses'][0]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testThreshold()
    {
        $this->assertEquals(2, self::$obj->getThreshold());
    }

    public function testDescription()
    {
        $this->assertEquals(
            'After using Innervate, the mana cost of your healing spells is reduced by 25% for 15 sec.',
            self::$obj->getDescription()
        );
    }
}