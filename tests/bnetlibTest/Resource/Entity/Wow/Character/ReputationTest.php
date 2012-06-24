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
use bnetlib\Resource\Entity\Wow\Character\Reputation;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ReputationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Reputation
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Reputation();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['reputation']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testHasEncountered()
    {
        $this->assertTrue(self::$obj->hasEncountered(1098));
    }

    public function testHasNotEncountered()
    {
        $this->assertFalse(self::$obj->hasEncountered(10908));
    }

    public function testById()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Faction', self::$obj->getById(1098));
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $faction) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Faction', $faction);
            break;
        }

        $this->assertTrue($tested);
    }
}