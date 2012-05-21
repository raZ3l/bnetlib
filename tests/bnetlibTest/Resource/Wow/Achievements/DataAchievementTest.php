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

namespace bnetlibTest\Resource\Wow\Achievements;

use bnetlib\Resource\Wow\Achievements\DataAchievement;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Achievements
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class DataAchievementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Achievements\DataAchievement
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character_achievements.json'
        ), true);

        self::$obj = new DataAchievement();
        self::$obj->populate($data['achievements'][1]['achievements'][1]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIsAchievement()
    {
        $this->assertTrue(self::$obj->isAchievement());
    }

    public function testId()
    {
        $this->assertEquals(1682, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('The Loremaster', self::$obj->getName());
    }

    public function testPoints()
    {
        $this->assertEquals(10, self::$obj->getPoints());
    }

    public function testDescription()
    {
        $this->assertEquals('Complete the quest achievements listed below.', self::$obj->getDescription());
    }

    public function hasCriteria()
    {
        $this->assertFalse(self::$obj->hasCriteria());
    }

    public function testCriteria()
    {
        $this->assertNull(self::$obj->getCriteria());
    }

    public function hasReward()
    {
        $this->assertTrue(self::$obj->hasReward());
    }

    public function hasRewardString()
    {
        $this->assertTrue(self::$obj->hasRewardString());
    }

    public function testReward()
    {
        $this->assertEquals('Reward: Title & Loremaster\'s Colors', self::$obj->getReward());
    }

    public function hasRewardItem()
    {
        $this->assertTrue(self::$obj->hasRewardItem());
    }

    public function testRewardItem()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Item\Reward', self::$obj->getRewardItem());
    }
}