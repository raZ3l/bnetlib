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

use bnetlib\Resource\Wow\Character\Instance;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class InstanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Instance
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Instance();
        self::$obj->populate($data['content']['progression']['raids'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testHasNoHeroicMode()
    {
        $this->assertFalse(self::$obj->hasHeroicMode());
    }

    public function testName()
    {
         $this->assertEquals('Molten Core', self::$obj->getName());
    }

    public function testNormal()
    {
         $this->assertEquals(2, self::$obj->getNormal());
    }

    public function testHeroic()
    {
         $this->assertEquals(0, self::$obj->getHeroic());
    }

    public function testId()
    {
         $this->assertEquals(2717, self::$obj->getId());
    }

    public function testBosses()
    {
         $this->assertInternalType('array', self::$obj->getBosses());
    }

    public function testIsClearOnNormal()
    {
         $this->assertTrue(self::$obj->isClearOnNormal());
    }

    public function testIsNotClearOnHeroic()
    {
         $this->assertFalse(self::$obj->isClearOnHeroic());
    }

    public function testNormalProgress()
    {
        $this->assertEquals('1/1', self::$obj->getNormalProgress());
    }

    public function testHeroicProgress()
    {
         $this->assertEquals('0/1', self::$obj->getHeroicProgress());
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $boss) {
            $this->assertInternalType('array', $boss);
        }
    }
}