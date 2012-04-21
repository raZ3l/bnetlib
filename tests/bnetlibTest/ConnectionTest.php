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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlibTest;

use bnetlib\Connection;

/**
 * @category   bnetlib
 * @package    Connection
 * @subpackage UnitTests
 * @group      Connection
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    protected $stub;

    protected $connection;

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
                           ->setMethods(array('_decodeJson'))
                           ->getMock();

        $connection->expects($this->once())
                   ->method('_decodeJson')
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
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'access_denied'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    public function testRequestCharacterFound()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character_found'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $response = $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));

        $this->assertArrayHasKey('content', $response);
        $this->assertArrayHasKey('headers', $response);
    }

    /**
     * @expectedException bnetlib\Exception\CacheException
     */
    public function testRequestCharacterFoundAndCached()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character_found_304'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /**
     * @expectedException bnetlib\Exception\PageNotFoundException
     */
    public function testRequestCharacterNotFound()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'character_not_found'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAppException
     */
    public function testRequestInvalidApplication()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'invalid_application'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAppPermissionsException
     */
    public function testRequestInvalidApplicationPermission()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'invalid_application_permissions'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAppSignatureException
     */
    public function testRequestInvalidApplicationSignature()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'invalid_application_signature'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /**
     * @expectedException bnetlib\Exception\InvalidAuthHeaderException
     */
    public function testRequestInvalidAuthHeader()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'invalid_authentication_header'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /**
     * @expectedException bnetlib\Exception\UnexpectedResponseException
     */
    public function testRequestUnkownReason400Status()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'some_unknown_error_400'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /**
     * @expectedException bnetlib\Exception\ServerErrorException
     */
    public function testRequestSomethingUnexpectedHappened()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'something_unexpected_happened'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
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
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'too_many_requests'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }

    /*
     * Zend\Client throws an InvalidAgrumentException if a status code 420 is returned.
     *
     * @expectedException bnetlib\Exception\RequestsThrottledException

    public function testRequestTooManyRequests420()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'too_many_requests_420'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }
    */

    /**
     * @expectedException bnetlib\Exception\RequestsThrottledException
     */
    public function testRequestTooManyRequests429()
    {
        $content = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'too_many_requests_429'
        );

        $this->stub->expects($this->once())
                   ->method('doRequest')
                   ->will($this->returnValue($content));

        $this->connection->request(array(
            'url'          => 'http://phpunittest.com/',
            'authenticate' => true
        ));
    }
}