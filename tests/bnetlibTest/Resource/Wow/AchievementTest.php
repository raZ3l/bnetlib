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

namespace bnetlibTest\Resource\Wow;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Wow\Achievement;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Achievement
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AchievementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Achievement
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/achievement.json'
        ), true);

        self::$obj = new Achievement();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIcon()
    {
        $this->assertEquals('achievement_bg_masterofallbgs', self::$obj->getIcon());
    }

    public function testCriteria()
    {
        $this->assertInternalType('array', self::$obj->getCriteria());
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $criteria) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Achievements\Criteria', $criteria);
        }
    }
}