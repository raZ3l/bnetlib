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

use bnetlib\Resource\Wow\Achievements\DataAchievements;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Achievements
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class DataAchievementsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Achievements\DataAchievements
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character_achievements.json'
        ), true);

        self::$obj = new DataAchievements();
        self::$obj->populate($data['achievements'][0]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIsNotSubCategory()
    {
        $this->assertFalse(self::$obj->isSubCategory());
    }

    public function testIsNotAchievement()
    {
        $this->assertFalse(self::$obj->isAchievement());
    }

    public function testCategory()
    {
        $this->assertEquals('General', self::$obj->getCategory());
    }

    public function testCategoryId()
    {
        $this->assertEquals(92, self::$obj->getCategoryId());
    }

    public function testTopCategory()
    {
        $this->assertNull(self::$obj->getTopCategory());
    }

    public function testTopCategoryId()
    {
        $this->assertNull(self::$obj->getTopCategoryId());
    }

    public function testTopCategoryWithValue()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character_achievements.json'
        ), true);

        $data['achievements'][1]['categories'][0]['top'] = array(96, 'Quests');

        $obj = new DataAchievements();
        $obj->populate($data['achievements'][1]['categories'][0]);

        $this->assertEquals('Quests', $obj->getTopCategory());
        $this->assertEquals(96, $obj->getTopCategoryId());
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $av) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Achievements\DataAchievement', $av);
        }
    }
}