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

namespace bnetlibTest\Resource\Wow;

use bnetlib\Resource\Wow\Realms;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Realms
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RealmsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Realms
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'realms.json'
        ), true);

        self::$obj = new Realms();
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
        foreach (self::$obj as $key => $realm) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Realms\Realm', $realm);
        }
    }
}