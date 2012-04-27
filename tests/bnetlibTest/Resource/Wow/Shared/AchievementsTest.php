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

namespace bnetlibTest\Resource\Wow\Shared;

use bnetlib\Resource\Wow\Shared\Achievements;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AchievementsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Shared\Achievements
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);;

        self::$obj = new Achievements();
        self::$obj->populate($data['content']['achievements']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testById()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\Achievement', self::$obj->getById(6));
    }

    public function testHas()
    {
        $this->assertTrue(self::$obj->has(6));
    }

    public function testHasNot()
    {
        $this->assertFalse(self::$obj->has(666));
    }
}