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

namespace bnetlibTest\Resource\Entity\Wow\Guild;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Guild\Reward;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Guild
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RewardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Guild\Reward
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/guild_rewards.json'
        ), true);

        self::$obj = new Reward();
        self::$obj->setServiceLocator(new ServiceLocator());
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
        $this->assertInstanceOf('bnetlib\Resource\Entity\Shared\ListData', self::$obj->getRaces());
    }

    public function testItem()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Item\Reward', self::$obj->getItem());
    }

    public function geAchievement()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Achievements\Achievement', self::$obj->geAchievement());
    }
}