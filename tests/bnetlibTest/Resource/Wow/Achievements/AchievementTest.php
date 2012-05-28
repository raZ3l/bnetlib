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

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Wow\Achievements\Achievement;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AchievementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Achievements\Achievement
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        self::$obj = new Achievement();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate(array(
            'a'   => 6,
            'ts'  => 1224092732000,
            'c'   => 34,
            'cq'  => 85,
            'cts' => 1333377449000,
            'cc'  => 1333377449000
        ));

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
       $this->assertEquals(6, self::$obj->getId());
    }

    public function testTimestamp()
    {
        $this->assertEquals(1224092732000, self::$obj->getTimestamp());
    }

    public function testCriteria()
    {
        $this->assertEquals(34, self::$obj->getCriteria());
    }

    public function testCriteriaQuantity()
    {
        $this->assertEquals(85, self::$obj->getCriteriaQuantity());
    }

    public function testCriteriaTimestamp()
    {
        $this->assertEquals(1333377449000, self::$obj->getCriteriaTimestamp());
    }

    public function testCriteriaCreated()
    {
        $this->assertEquals(1333377449000, self::$obj->getCriteriaCreated());
    }
}