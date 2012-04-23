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

use bnetlib\Resource\Wow\Character\Instance;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
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
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
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
         $this->assertEquals(self::$obj->getName(), 'Molten Core');
    }

    public function testNormal()
    {
         $this->assertEquals(self::$obj->getNormal(), 2);
    }

    public function testHeroic()
    {
         $this->assertEquals(self::$obj->getHeroic(), 0);
    }

    public function testId()
    {
         $this->assertEquals(self::$obj->getId(), 2717);
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
        $this->assertEquals(self::$obj->getNormalProgress(), '1/1');
    }

    public function testHeroicProgress()
    {
         $this->assertEquals(self::$obj->getHeroicProgress(), '0/1');
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $boss) {
            $this->assertInternalType('array', $boss);
        }
    }
}