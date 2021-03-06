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
use bnetlib\Resource\Entity\Wow\Realms;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Realms
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RealmsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Realms
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/realms.json'
        ), true);

        self::$obj = new Realms();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testByStatus()
    {
        $this->assertInternalType('array', self::$obj->getByQueueStatus(true));
    }

    public function testByQueueStatus()
    {
        $this->assertInternalType('array', self::$obj->getByQueueStatus(true));
    }

    public function testByType()
    {
        $this->assertInternalType('array', self::$obj->getByType(Realms::TYPE_PVE));
    }

    public function testByPopulation()
    {
        $this->assertInternalType('array', self::$obj->getByPopulation(Realms::POPULATION_LOW));
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $realm) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Realms\Realm', $realm);
            break;
        }

        $this->assertTrue($tested);
    }
}