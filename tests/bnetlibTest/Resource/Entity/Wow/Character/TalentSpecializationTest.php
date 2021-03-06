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
use bnetlib\Resource\Entity\Wow\Character\TalentSpecialization;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class TalentSpecializationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\TalentSpecialization
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new TalentSpecialization();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['talents'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIsSelected()
    {
        $this->assertFalse(self::$obj->isSelected());
    }

    public function testIsSpecialized()
    {
        $this->assertTrue(self::$obj->isSpecialized());
    }

    public function testName()
    {
        $this->assertEquals('Arcane', self::$obj->getName());
    }

    public function testIcon()
    {
        $this->assertEquals('spell_holy_magicalsentry', self::$obj->getIcon());
    }

    public function testBuild()
    {
        $this->assertEquals(
            '3033022212301222101212300000000000000000000300000000000000000',
            self::$obj->getBuild()
        );
    }

    public function testSimpleBuild()
    {
        $this->assertEquals('33/5/3', self::$obj->getSimpleBuild());
    }

    public function testTrees()
    {
        $this->assertInternalType('array', self::$obj->getTrees());
    }

    public function testGlyphs()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Glyphs', self::$obj->getGlyphs());
    }
}