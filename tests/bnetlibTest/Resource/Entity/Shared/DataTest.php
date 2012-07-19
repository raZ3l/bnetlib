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

namespace bnetlibTest\Resource\Entity\Shared;

use bnetlib\ServiceLocator\ServiceLocator;
use bnetlib\Resource\Entity\Shared\Data;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \bnetlib\Resource\Entity\Shared\Data
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/Wow/fixtures/character.json'
        ), true);;

        self::$obj = new Data();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['quests']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $item) {
            $this->assertInternalType('integer', $item);
        }
    }
}