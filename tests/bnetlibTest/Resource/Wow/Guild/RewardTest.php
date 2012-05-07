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

namespace bnetlibTest\Resource\Wow\Guild;

use bnetlib\Resource\Wow\Guild\Reward;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Guild
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RewardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Guild\Reward
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'guild_rewards.json'
        ), true);

        self::$obj = new Reward();
        self::$obj->populate($data['content']['rewards'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testMinGuildLevel()
    {
        $this->assertEquals(0, self::$obj->getMinGuildLevel());
    }

    public function testMinGuildStanding()
    {
        $this->assertEquals(6, self::$obj->getMinGuildStanding());
    }

    public function testRaces()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Shared\ListData', self::$obj->getRaces());
    }

    public function testItem()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Item\Reward', self::$obj->getItem());
    }

    public function geAchievement()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Achievements\Achievement', self::$obj->geAchievement());
    }
}