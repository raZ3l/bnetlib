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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlibTest\Resource;

use bnetlib\Resource\Wow\Character\Title;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class TitleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\Character\Title
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character.json'
        ), true);;

        $data['content']['titles'][0]['character'] = 'Coss';

        self::$obj = new Title();
        self::$obj->populate($data['content']['titles'][0]);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(63, self::$obj->getId());
    }

    public function testTitle()
    {
        $this->assertEquals('%s of the Shattered Sun', self::$obj->getTitle());
    }

    public function testFullName()
    {
        $this->assertEquals('Coss of the Shattered Sun', self::$obj->getFullName());
    }

    public function testIsSelected()
    {
        $this->assertFalse(self::$obj->isSelected());
    }
}