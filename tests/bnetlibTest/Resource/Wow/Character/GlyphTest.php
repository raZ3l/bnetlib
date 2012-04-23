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

use bnetlib\Resource\Wow\Character\Glyph;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class GlyphTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Glyph
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);

        $data['content']['talents'][0]['glyphs']['prime'][0]['type'] = 'prime';

        self::$obj = new Glyph();
        self::$obj->populate($data['content']['talents'][0]['glyphs']['prime'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testGlyphId()
    {
        $this->assertEquals(self::$obj->getGlyphId(), 651);
    }

    public function testItemId()
    {
        $this->assertEquals(self::$obj->getItemId(), 44955);
    }

    public function testGlyphType()
    {
        $this->assertEquals(self::$obj->getGlyphType(), 'prime');
    }

    public function testName()
    {
        $this->assertEquals(self::$obj->getName(), 'Glyph of Arcane Blast');
    }

    public function testIcon()
    {
        $this->assertEquals(self::$obj->getIcon(), 'spell_arcane_blast');
    }

    public function testIsPrime()
    {
        $this->assertTrue(self::$obj->isPrime());
    }

    public function testIsNotMajor()
    {
        $this->assertFalse(self::$obj->isMajor());
    }

    public function testIsNotMinor()
    {
        $this->assertFalse(self::$obj->isMinor());
    }
}