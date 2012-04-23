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

use bnetlib\Resource\Wow\Character\Appearance;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class AppearanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Appearance
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);

        self::$obj = new Appearance();
        self::$obj->populate($data['content']['appearance']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testFaceVariation()
    {
        $this->assertEquals(self::$obj->getFaceVariation(), 4);
    }

    public function testSkinColor()
    {
        $this->assertEquals(self::$obj->getSkinColor(), 1);
    }

    public function testHairVariation()
    {
        $this->assertEquals(self::$obj->getHairVariation(), 1);
    }

    public function testHairColor()
    {
        $this->assertEquals(self::$obj->getHairColor(), 7);
    }

    public function testFeatureVariation()
    {
        $this->assertEquals(self::$obj->getFeatureVariation(), 4);
    }

    public function testShowHelm()
    {
         $this->assertTrue(self::$obj->isShowingHelm());
    }

    public function testShowCloak()
    {
        $this->assertFalse(self::$obj->isShowingCloak());
    }
}