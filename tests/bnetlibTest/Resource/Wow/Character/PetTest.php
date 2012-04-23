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

namespace bnetlibTest\Resource;

use bnetlib\Resource\Wow\Character\Pet;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class PetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Pet
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);;

        self::$obj = new Pet();
        self::$obj->populate($data['content']['pets'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIsSelected()
    {
        $this->assertFalse(self::$obj->isSelected());
    }

    public function testName()
    {
        $this->assertEquals('Geisterbestie', self::$obj->getName());
    }

    public function testCreature()
    {
        $this->assertEquals(32517, self::$obj->getCreature());
    }

    public function testSlot()
    {
        $this->assertEquals(0, self::$obj->getSlot());
    }
}