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
use bnetlib\Resource\Entity\Wow\Character\Titles;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOfWarcraft
 * @group      WoW_Character
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class TitlesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Character\Titles
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data            = array();
        $data['content'] = json_decode(file_get_contents(
            dirname(__DIR__) . '/fixtures/character.json'
        ), true);;

        self::$obj = new Titles();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data['content']['titles']);

    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testHasSelected()
    {
        $this->assertTrue(self::$obj->hasSelected());
    }

    public function testSelected()
    {
        $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Title', self::$obj->getSelected());
    }

    public function testIterator()
    {
        $tested = false;

        foreach (self::$obj as $key => $title) {
            $tested = true;
            $this->assertInstanceOf('bnetlib\Resource\Entity\Wow\Character\Title', $title);
            break;
        }

        $this->assertTrue($tested);
    }
}