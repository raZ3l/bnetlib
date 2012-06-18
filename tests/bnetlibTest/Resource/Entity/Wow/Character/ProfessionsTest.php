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
use bnetlib\Resource\Entity\Wow\Character\Professions;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ProfessionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Professions
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Professions();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['professions']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testById()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Profession', self::$obj->getById(171));
    }
    public function testByUndefinedId()
    {
        $this->assertNull(self::$obj->getById(164));
    }

    public function testHasAlchemy()
    {
        $this->assertTrue(self::$obj->hasAlchemy());
    }

    public function testHasNotBlacksmithing()
    {
        $this->assertFalse(self::$obj->hasBlacksmithing());
    }

    public function testHasNotEnchanting()
    {
        $this->assertFalse(self::$obj->hasEnchanting());
    }

    public function testHasNotEngineering()
    {
        $this->assertFalse(self::$obj->hasEngineering());
    }

    public function testHasNotHerbalism()
    {
        $this->assertFalse(self::$obj->hasHerbalism());
    }

    public function testHasNotInscription()
    {
        $this->assertFalse(self::$obj->hasInscription());
    }

    public function testHasJewelcrafting()
    {
        $this->assertTrue(self::$obj->hasJewelcrafting());
    }

    public function testHasNotLeatherworking()
    {
        $this->assertFalse(self::$obj->hasLeatherworking());
    }

    public function testHasNotMining()
    {
        $this->assertFalse(self::$obj->hasMining());
    }

    public function testHasNotSkinning()
    {
        $this->assertFalse(self::$obj->hasSkinning());
    }

    public function testHasNotTailoring()
    {
        $this->assertFalse(self::$obj->hasTailoring());
    }

    public function testHasFirstAid()
    {
        $this->assertTrue(self::$obj->hasFirstAid());
    }

    public function testHasArchaeology()
    {
        $this->assertTrue(self::$obj->hasArchaeology());
    }

    public function testHasFishing()
    {
        $this->assertTrue(self::$obj->hasFishing());
    }

    public function testHasCooking()
    {
        $this->assertTrue(self::$obj->hasCooking());
    }

    public function testHasPrimaryProfession()
    {
        $this->assertTrue(self::$obj->hasPrimaryProfession());
    }

    public function testHasSecondaryProfession()
    {
        $this->assertTrue(self::$obj->hasSecondaryProfession());
    }

    public function testHasNoGatherProfession()
    {
        $this->assertFalse(self::$obj->hasGatherProfession());
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $prof) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Profession', $prof);
            break;
        }

        $this->assertTrue($tested);
    }
}