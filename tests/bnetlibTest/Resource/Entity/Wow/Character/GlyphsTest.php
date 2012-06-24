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
use bnetlib\Resource\Entity\Wow\Character\Glyphs;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class GlyphsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Glyphs
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Glyphs();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['talents'][0]['glyphs']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testCountable()
    {
        $this->assertEquals(9, count(self::$obj));
    }

    public function testHasGlyphs()
    {
        $this->assertTrue(self::$obj->hasGlyphs());
    }

    public function testHasPrime()
    {
        $this->assertTrue(self::$obj->hasPrime());
    }

    public function testPrime()
    {
        $this->assertInternalType('array', self::$obj->getPrime());
    }

    public function testHasMajor()
    {
        $this->assertTrue(self::$obj->hasMajor());
    }

    public function testMajor()
    {
        $this->assertInternalType('array', self::$obj->getMajor());
    }

    public function testHasMinor()
    {
        $this->assertTrue(self::$obj->hasMinor());
    }

    public function testMinor()
    {
        $this->assertInternalType('array', self::$obj->getMinor());
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $team) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Glyph', $team);
            break;
        }

        $this->assertTrue($tested);
    }
}