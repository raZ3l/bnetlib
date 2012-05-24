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

namespace bnetlibTest;

use bnetlib\Connection;

/**
 * @category   bnetlib
 * @package    Connection
 * @subpackage UnitTests
 * @group      Connection
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    protected static $params;

    protected $stub;

    protected $connection;

    public static function setUpBeforeClass()
    {
        self::$params = array(
            'url'          => 'http://example.org/',
            'json'         => true,
            'authenticate' => true
        );
    }

    public static function tearDownAfterClass()
    {
        self::$params = null;
    }

    public function setUp()
    {
        $this->stub       = $this->getMockBuilder('Zend\Http\Client')
                                 ->setMethods(array('doRequest'))
                                 ->getMock();
        $this->connection = new Connection($this->stub);
    }

    public function tearDown()
    {
        unset($this->stub, $this->connection);
    }

    public function testSetConfigAutoHttps()
    {
        $connection = new Connection();
        $connection->setConfig(array(
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

        $connection = $this->getMockBuilder('bnetlib\Connection')
                           ->setMethods(array('decodeJson'))
                           ->getMock();

        $connection->expects($this->once())
                   ->method('decodeJson')
                   ->will($this->returnArgument(0));

        $connection->setConfig(array(
            'securerequests' => false,
            'keys' => array(
                'public'  => '123PUBLIC456',
                'private' => '987PRIVATE65'
            )
        ));

        $response = $connection->request(array(
            'url'          => 'http://everynothing.net/bnetauthtest.php?test=1',
            'json'         => true,
            'authenticate' => true
        ));

        $this->assertEquals("Your authentication headers look good!\n", $response['content']);

    }

    /**
     * @expectedException bnetlib\Exception\RequestBlockedException
     */
    public function testRequestAccessDenied()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/access_denied'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    public function testRequestCharacterFound()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/character_found'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $response = $this->connection->request(self::$params);

        $this->assertArrayHasKey('content', $response);
        $this->assertArrayHasKey('headers', $response);
    }

    /**
     * @expectedException bnetlib\Exception\CacheException
     */
    public function testRequestCharacterFoundAndCached()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/character_found_304'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\PageNotFoundException
     */
    public function testRequestCharacterNotFound()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/character_not_found'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAppException
     */
    public function testRequestInvalidApplication()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/invalid_application'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAppPermissionsException
     */
    public function testRequestInvalidApplicationPermission()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/invalid_application_permissions'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAppSignatureException
     */
    public function testRequestInvalidApplicationSignature()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/invalid_application_signature'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAuthHeaderException
     */
    public function testRequestInvalidAuthHeader()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/invalid_authentication_header'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\UnexpectedResponseException
     */
    public function testRequestUnkownReason400Status()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/some_unknown_error_400'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\ServerErrorException
     */
    public function testRequestSomethingUnexpectedHappened()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/something_unexpected_happened'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /**
     * @expectedException bnetlib\Exception\DomainException
     */
    public function testGetHostThrowsError()
    {
        $this->connection->getHost('yadayadayada');
    }

    /**
     * @expectedException bnetlib\Exception\RequestsThrottledException
     */
    public function testRequestTooManyRequests()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/too_many_requests'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }

    /*
     * Zend\Client throws an InvalidAgrumentException if a status code 420 is returned.
     *
     * @expectedException bnetlib\Exception\RequestsThrottledException

    public function testRequestTooManyRequests420()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/too_many_requests_420'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }
    */

    /**
     * @expectedException bnetlib\Exception\RequestsThrottledException
     */
    public function testRequestTooManyRequests429()
    {
        $content = file_get_contents(
            __DIR__ . '/fixtures/too_many_requests_429'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(self::$params);
    }
}