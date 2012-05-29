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
use bnetlib\Resource\Entity\Wow\Recipe;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      WorldOFWarcraft
 * @group      WoW_Recipe
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class RecipeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Wow\Recipe
     */
    protected static $obj;

    public static function setUpBeforeClass()
    {
        $data = json_decode(file_get_contents(
            __DIR__ . '/fixtures/recipe_33994.json'
        ), true);

        self::$obj = new Recipe();
        self::$obj->setServiceLocator(new ServiceLocator());
        self::$obj->populate($data);
    }

    public static function tearDownAfterClass()
    {
        self::$obj = null;
    }

    public function testId()
    {
        $this->assertEquals(33994, self::$obj->getId());
    }

    public function testName()
    {
        $this->assertEquals('Enchant Gloves - Precise Strikes', self::$obj->getName());
    }

    public function testIcon()
    {
        $this->assertEquals('spell_holy_greaterheal', self::$obj->getIcon());
    }

    public function testProfession()
    {
        $this->assertEquals('Enchanting', self::$obj->getProfession());
    }
}