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

namespace bnetlibTest\Resource\Shared;

use bnetlib\Resource\Shared\File;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      Shared
 * @group      Shared_File
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bnetlib\Resource\Shared\File
     */
    protected static $obj;

    /**
     * @var string
     */
    protected static $hash;

    public static function setUpBeforeClass()
    {
        $file = file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Wow' . DIRECTORY_SEPARATOR
            . '_files' . DIRECTORY_SEPARATOR . 'thumbnail.jpg'
        );

        self::$hash = md5($file);
        self::$obj  = new File();
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

    public function testSaveAs()
    {
        $tempnam = tempnam(sys_get_temp_dir(), 'phpunit') . '.jpg';

        self::$obj->saveAs($tempnam);

        $this->assertEquals(self::$hash, md5(file_get_contents($tempnam)));

        unlink($tempnam);
    }
}