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

use bnetlib\Resource\Entity\Shared\Image;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      Shared
 * @group      Shared_File
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Entity\Shared\Image
     */
    protected static $obj;

    /**
     * @var string
     */
    protected static $hash;

    public static function setUpBeforeClass()
    {
        $file = file_get_contents(
            dirname(__DIR__) . '/Wow' . DIRECTORY_SEPARATOR
            . 'fixtures/thumbnail.jpg'
        );

        self::$hash = md5($file);
        self::$obj  = new Image();
        self::$obj->populate($file);
    }

    public static function tearDownAfterClass()
    {
        self::$obj  = null;
        self::$hash = null;
    }

    public function testData()
    {
        $this->assertEquals(self::$hash, md5(self::$obj->getData()));
    }

    public function testSaveAsWithoutExtension()
    {
        $tempnam = tempnam(sys_get_temp_dir(), 'phpunit');

        self::$obj->saveAs($tempnam);

        $tempnam .= '.jpg';

        $this->assertEquals(self::$hash, md5(file_get_contents($tempnam)));

        unlink($tempnam);
    }

    public function testSaveAsJpg()
    {
        $tempnam = tempnam(sys_get_temp_dir(), 'phpunit') . '.jpg';

        self::$obj->saveAs($tempnam);

        $this->assertEquals(self::$hash, md5(file_get_contents($tempnam)));

        unlink($tempnam);
    }

    public function testSaveAsJpeg()
    {
        $tempnam = tempnam(sys_get_temp_dir(), 'phpunit') . '.jpeg';

        self::$obj->saveAs($tempnam);

        $this->assertEquals(self::$hash, md5(file_get_contents($tempnam)));

        unlink($tempnam);
    }

    public function testSaveAsPng()
    {
        $tempnam = tempnam(sys_get_temp_dir(), 'phpunit') . '.png';

        self::$obj->saveAs($tempnam);

        $tempnam .= '.jpg';

        $this->assertEquals(self::$hash, md5(file_get_contents($tempnam)));

        unlink($tempnam);
    }
}