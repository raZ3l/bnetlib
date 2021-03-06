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
use bnetlib\Resource\Entity\Wow\Character\FeedEntry;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class FeedEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\FeedEntry
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new FeedEntry();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['feed'][2]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testType()
    {
        $this->assertEquals('CRITERIA', self::$obj->getType());
    }

    public function testTimestamp()
    {
        $this->assertEquals('1334115489000', self::$obj->getTimestamp());
    }

    public function testHasAchievement()
    {
        $this->assertTrue(self::$obj->hasAchievement());
    }

    public function testAchievement()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Achievements\DataAchievement', self::$obj->getAchievement());
    }

    public function testHasCriteria()
    {
        $this->assertTrue(self::$obj->hasCriteria());
    }

    public function testCriteria()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Achievements\Criteria', self::$obj->getCriteria());
    }

    public function testItemId()
    {
        $this->assertNull(self::$obj->getItemId());
    }

    public function testIsNotFeatOfStrength()
    {
        $this->assertFalse(self::$obj->isFeatOfStrength());
    }
}