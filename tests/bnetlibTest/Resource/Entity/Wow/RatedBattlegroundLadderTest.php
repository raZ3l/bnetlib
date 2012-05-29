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

namespace bnetlibTest\Resource\Entity\Wow;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Wow\RatedBattlegroundLadder;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_RatedBattlegroundLadder
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RatedBattlegroundLadderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\RatedBattlegroundLadder
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/rbg_ladder.json'
        ), true);

        self::$obj = new RatedBattlegroundLadder();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testById()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Record', self::$obj->getById(1));
    }

    public function testByRank()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Record', self::$obj->getByRank(1));
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $char) {
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Record', $char);
        }
    }
}