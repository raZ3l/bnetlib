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

namespace bnetlibTest\Resource\Entity\Wow\Character;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Character\Glyph;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class GlyphTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Glyph
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);

        $data['content']['talents'][0]['glyphs']['prime'][0]['type'] = 'prime';

        self::$obj = new Glyph();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['talents'][0]['glyphs']['prime'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testGlyphId()
    {
        $this->assertEquals(651, self::$obj->getGlyphId());
    }

    public function testItemId()
    {
        $this->assertEquals(44955, self::$obj->getItemId());
    }

    public function testGlyphType()
    {
        $this->assertEquals('prime', self::$obj->getGlyphType());
    }

    public function testName()
    {
        $this->assertEquals('Glyph of Arcane Blast', self::$obj->getName());
    }

    public function testIcon()
    {
        $this->assertEquals('spell_arcane_blast', self::$obj->getIcon());
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