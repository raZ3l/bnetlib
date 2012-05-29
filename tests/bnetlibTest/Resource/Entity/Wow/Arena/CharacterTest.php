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

namespace bnetlibTest\Resource\Entity\Wow\Arena;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Arena\Character;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Arena
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class CharacterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\ArenaLadder\Character
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/arena_ladder.json'
        ), true);

        $stats = array();
        foreach ($data['arenateam'][0]['members'][0] as $stat => $sval) {
            if ($stat === 'character') {
                continue;
            }
            $stats[$stat] = $sval;
        }
        $data['arenateam'][0]['members'][0]['character']['statistic'] = $stats;

        self::$obj = new Character();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['arenateam'][0]['members'][0]['character']);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testStatistic()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Arena\Statistic', self::$obj->getStatistic());
    }
}