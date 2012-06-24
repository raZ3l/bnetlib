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

namespace bnetlibTest\Resource\Entity\Wow;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Quest;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Quest
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class QuestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Quest
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/quest_13146.json'
        ), true);

        self::$obj = new Quest();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(13157, self::$obj->getId());
    }

    public function testTitle()
    {
        $this->assertEquals('The Crusaders\' Pinnacle', self::$obj->getTitle());
    }

    public function testRequiredLevel()
    {
        $this->assertEquals(77, self::$obj->getRequiredLevel());
    }

    public function testHasNoPartyMemberSuggestion()
    {
        $this->assertFalse(self::$obj->hasPartyMemberSuggestion());
    }

    public function testSuggestedPartyMembers()
    {
        $this->assertEquals(0, self::$obj->getSuggestedPartyMembers());
    }

    public function testCategory()
    {
        $this->assertEquals('Icecrown', self::$obj->getCategory());
    }

    public function testLevel()
    {
        $this->assertEquals(79, self::$obj->getLevel());
    }
}