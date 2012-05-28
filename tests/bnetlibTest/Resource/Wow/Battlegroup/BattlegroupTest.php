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

namespace bnetlibTest\Resource\Wow\Battlegroups;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Wow\Battlegroups\Battlegroup;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Battlegroups
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class BattlegroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Battlegroups\Battlegroup
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/battlegroups.json'
        ), true);

        self::$obj = new Battlegroup();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['battlegroups'][0]);
    }

    public function testName()
    {
        $this->assertEquals('Battle net Invitational BG', self::$obj->getName());
    }

    public function testSlug()
    {
        $this->assertEquals('battle-net-invitational-bg', self::$obj->getSlug());
    }
}