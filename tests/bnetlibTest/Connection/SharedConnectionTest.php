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
 * @package    Connection
 * @subpackage UnitTests
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\Connection;

use bnetlib\Resource\Config\Wow\Character;

/**
 * @category   bnetlib
 * @package    Connection
 * @subpackage UnitTests
 * @group      Connection
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
abstract class SharedConnectionTest extends \PHPUnit_Framework_TestCase
{
    protected static $params;

    protected $adapter;

    protected $stub;

    protected $connection;

    public static function setUpBeforeClass()
    {
        self::$params = array(
            'url'    => 'http://example.org/',
            'config' => new Character(),
        );
    }

    public static function tearDownAfterClass()
    {
        self::$params = null;
    }

    public function tearDown()
    {
        unset($this->adapter, $this->stub, $this->connection);
    }

    public function testSetConfigAutoHttps()
    {
        $connection = new $this->adapter();
        $connection->setOptions(array(
            'keys' => array(
                'public'  => 'public',
                'private' => 'private'
            )
        ));
        $this->assertTrue($connection->doSecureRequest());

    }

    public function testSignedRequest()
    {
        if (!defined('TESTS_ONLINE') || TESTS_ONLINE === false) {
            $this->markTestSkipped('Skipped by TestConfiguration (TESTS_ONLINE)');
        }
        if (!defined('TESTS_CONNECTION_ONLINE') || TESTS_CONNECTION_ONLINE === false) {
            $this->markTestSkipped('Skipped by TestConfiguration (TESTS_CONNECTION_ONLINE)');
        }

        $connection = $this->getMockBuilder($this->adapter)
                           ->setMethods(array('decodeJson'))
                           ->getMock();

        $connection->expects($this->once())
                   ->method('decodeJson')
                   ->will($this->returnArgument(0));

        $connection->setOptions(array(
            'securerequests' => false,
            'keys' => array(
                'public'  => '123PUBLIC456',
                'private' => '987PRIVATE65'
            )
        ));

        $response = $connection->request(array(
            'url'          => 'http://everynothing.net/bnetauthtest.php?test=1',
            'config' => new Character(),
        ));

        $this->assertEquals("Your authentication headers look good!\n", $response['content']);
    }
}