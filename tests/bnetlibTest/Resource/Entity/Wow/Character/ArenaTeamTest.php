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

namespace bnetlibTest\Resource\Entity\Wow\Character;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\Character\ArenaTeam;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ArenaTeamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\ArenaTeam
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);

        self::$obj = new ArenaTeam();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['pvp']['arenaTeams'][0]);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testPersonalRating()
    {
        $this->assertEquals(2700, self::$obj->getPersonalRating());
    }
}