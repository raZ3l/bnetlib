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

use bnetlib\Resource\Wow\Guild\Spell;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Guild
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class SpellTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Guild\Spell
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'guild_perks.json'
        ), true);

        self::$obj = new Spell();
        self::$obj->populate($data['content']['perks'][0]['spell']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(78631, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('Fast Track', self::$obj->getName());
    }

    public function testHasSubtext()
    {
        $this->assertTrue(self::$obj->hasSubtext());
    }

    public function testSubtext()
    {
        $this->assertEquals('Rank 1', self::$obj->getSubtext());
    }

    public function testIcon()
    {
        $this->assertEquals('achievement_guildperk_fasttrack', self::$obj->getIcon());
    }

    public function testDescription()
    {
        $this->assertEquals(
            'Experience gained from killing monsters and completing quests increased by 5%.',
            self::$obj->getDescription()
        );
    }
}