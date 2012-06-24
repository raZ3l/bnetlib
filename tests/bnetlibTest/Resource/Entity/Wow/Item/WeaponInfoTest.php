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
use bnetlib\Resource\Entity\Wow\Item\WeaponInfo;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Item
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class WeaponInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Item\WeaponInfo
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/item_38268.json'
        ), true);

        self::$obj = new WeaponInfo();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['weaponInfo']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testMinDamage()
    {
        $this->assertEquals(1, self::$obj->getMinDamage());
    }

    public function testMaxDamage()
    {
        $this->assertEquals(2, self::$obj->getMaxDamage());
    }

    public function testSpeed()
    {
        $this->assertEquals(2.5, self::$obj->getSpeed());
    }

    public function testDps()
    {
        $this->assertEquals(0.6, self::$obj->getDps());
    }
}