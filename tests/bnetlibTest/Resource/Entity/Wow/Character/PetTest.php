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

namespace bnetlibTest\Resource\Entity\Wow\Character;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Character\Pet;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class PetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Pet
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Pet();
        self::$obj->setServiceLocator(new ServiceLocator());
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