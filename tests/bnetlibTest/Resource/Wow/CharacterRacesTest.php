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

use bnetlib\Resource\Wow\CharacterRaces;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_CharacterRaces
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class CharacterRacesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Wow\CharacterRaces
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/character_races.json'
        ), true);

        self::$obj = new CharacterRaces();
        self::$obj->populate($data);
    }

    public function testById()
    {
        $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Race', self::$obj->getById(3));
    }

    public function testIterator()
    {
        foreach (self::$obj as $key => $bg) {
            $this->assertInstanceOf('bnetlib\Resource\Wow\Character\Race', $bg);
        }
    }
}