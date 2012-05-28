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

use bnetlib\AbstractGame;
use bnetlib\Connection\ConnectionInterface;

/**
 * @category   bnetlib
 * @package    Game
 * @subpackage UnitTests
 * @group      Game
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AbstractGameTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;

    public function setUp()
    {
        $connection = $this->getMockBuilder('bnetlib\Connection\ZendFramework')
                           ->setMethods(array('request'))
                           ->getMock();

        // Can't use once even if I overwrite the mock for some classes
        $connection->expects($this->any())
                   ->method('request')
                   ->will($this->returnCallback(function () {
                        $args = func_get_args();
                        return array(
                            'content' => $args[0],
                            'headers' => array('foo' => 'bar')
                        );
                   }));

        $this->obj = new TestAssets\FakeGame($connection, new TestAssets\FakeServiceLocator());
    }

    public function tearDown()
    {
        unset($this->obj);
    }

    public function testGetSupportedLocale()
    {
        $this->assertEquals('bar', $this->obj->getSupportedLocale('foo'));
        $this->assertNull($this->obj->getSupportedLocale('foobar'));
    }

    public function testReturnType()
    {
        $response = $this->obj->getStaticUrl(array('url' => 'http://example.org/',));

        $this->assertInstanceOf('bnetlibTest\TestAssets\FakeResource', $response);
    }

    public function testReplaceHttpWithHttps()
    {
        $this->obj->getConnection()->setOptions(array('securerequests' => true));
        $response = $this->obj->getStaticUrl('http://example.org/');
        $data     = $response->getData();

        $this->assertEquals('https://example.org/', $data['url']);
    }

    public function testDontReplaceHttpWithHttps()
    {
        $this->obj->getConnection()->setOptions(array('securerequests' => true));
        $this->obj->getServiceLocator()->set('test.config.staticurl', 'bnetlibTest\TestAssets\StaticUrlCfgNoAuth');
        $response = $this->obj->getStaticUrl('http://example.org/');
        $data     = $response->getData();

        $this->assertEquals('http://example.org/', $data['url']);
    }

    public function testMagicResource()
    {
        $response = $this->obj->getDynamicUrl(new TestAssets\FakeMagicResource());
        $data = $response->getData();

        $this->assertEquals('http://www.example.org/dynamic/FOOBAR', $data['url']);
    }

    public function testMagicResourceWithArrayOverwrite()
    {
        $response = $this->obj->getDynamicUrl(
            new TestAssets\FakeMagicResource(),
            array('end' => 'overwritten')
        );
        $data = $response->getData();

        $this->assertEquals('http://www.example.org/dynamic/OVERWRITTEN', $data['url']);
    }

    public function testReturnArrayInsteadOfObject()
    {
        $response = $this->obj->getStaticUrl(array(
            'url' => 'http://example.org/',
            'return' => AbstractGame::RETURN_PLAIN
        ));

        if (!is_array($response)) {
            $this->fail('Unexpected response.');
        }
    }

    public function testStaticUrlWithUrlAsString()
    {
        $response = $this->obj->getStaticUrl('http://example.org/');
        $data     = $response->getData();

        $this->assertEquals('http://example.org/', $data['url']);
    }

    public function testStaticUrlWithUrlAsArray()
    {
        $response = $this->obj->getStaticUrl(array('url' => 'http://example.org/'));
        $data     = $response->getData();

        $this->assertEquals('http://example.org/', $data['url']);
    }

    /**
     * @expectedException bnetlib\Exception\BadMethodCallException
     */
    public function testStaticPathWithNoRegion()
    {
        $this->obj->getStaticPath();
    }

    public function testStaticPathWithRegion()
    {
        $response = $this->obj->getStaticPath(array('region' => ConnectionInterface::REGION_US));
        $data     = $response->getData();

        $this->assertEquals('http://us.battle.net/static/resource', $data['url']);
    }

    public function testStaticPathWithQueryParam()
    {
        $response = $this->obj->getStaticPath(array(
            'test'   => 'asdasd',
            'region' => ConnectionInterface::REGION_US
        ));
        $data = $response->getData();

        $this->assertEquals('http://us.battle.net/static/resource?test=asdasd', $data['url']);
    }

    public function testDynamicUrl()
    {
        $response = $this->obj->getDynamicUrl(array(
            'sub' => 'www',
            'end' => 'foobar'
        ));
        $data = $response->getData();

        $this->assertEquals('http://www.example.org/dynamic/FOOBAR', $data['url']);
    }

    public function testDynamicUrlWithHttps()
    {
        $this->obj->getConnection()->setOptions(array('securerequests' => true));
        $response = $this->obj->getDynamicUrl(array(
            'sub' => 'www',
            'end' => 'foobar'
        ));
        $data = $response->getData();

        $this->assertEquals('https://www.example.org/dynamic/FOOBAR', $data['url']);
    }

    public function testDynamicUrlWithLocale()
    {
        $response = $this->obj->getDynamicUrl(array(
            'sub'    => 'www',
            'end'    => 'foobar',
            'locale' => ConnectionInterface::LOCALE_DE
        ));
        $data = $response->getData();

        $this->assertEquals('http://www.example.org/dynamic/FOOBAR?locale=de_DE', $data['url']);
    }

    /**
     * @expectedException bnetlib\Exception\BadMethodCallException
     */
    public function testDynamicPathWithNoRegion()
    {
        $response = $this->obj->getDynamicPath(array(
            'one'   => '1',
            'two'   => '2',
            'three' => '3'
        ));
    }

    /**
     * @expectedException bnetlib\Exception\BadMethodCallException
     */
    public function testDynamicPathWithMissingArg()
    {
        $response = $this->obj->getDynamicPath(array(
            'one'   => '1',
            'two'   => '2',
            'region' => ConnectionInterface::REGION_US
        ));
    }

    public function testDynamicPathWithAliasSec()
    {
        $response = $this->obj->getDynamicPath(array(
            'one'    => '1',
            'sec'    => 'two',
            'three'  => '3',
            'region' => ConnectionInterface::REGION_US
        ));
        $data = $response->getData();

        $this->assertEquals('http://us.battle.net/dynamic/path/1/TWO/3', $data['url']);
    }

    public function testDynamicPathWithOptionalArgs()
    {
        $response = $this->obj->getDynamicPath(array(
            'one'    => 'haha',
            'sec'    => 'two',
            'three'  => '3',
            'bar'    => 'asd',
            'foo'    => 'asd',
            'region' => ConnectionInterface::REGION_US
        ));
        $data = $response->getData();

        $this->assertEquals('http://us.battle.net/dynamic/path/HAHA/TWO/3?foo=asd&bar=asd', $data['url']);
    }

    public function testDynamicPathWithOptionalArgsAndLocale()
    {
        $response = $this->obj->getDynamicPath(array(
            'one'    => 'haha',
            'sec'    => 'two',
            'three'  => '3',
            'bar'    => 'asd',
            'foo'    => 'asd',
            'locale' => ConnectionInterface::LOCALE_DE,
            'region' => ConnectionInterface::REGION_US
        ));
        $data = $response->getData();

        $this->assertEquals(
            'http://us.battle.net/dynamic/path/HAHA/TWO/3?locale=de_DE&foo=asd&bar=asd',
            $data['url']
        );
    }

    public function testDynamicPathWithOptionalAliasArgAndLocale()
    {
        $response = $this->obj->getDynamicPath(array(
            'one'    => 'haha',
            'sec'    => 'two',
            'three'  => '3',
            'sdfsdf' => 'asd',
            'fooo'   => 'def',
            'locale' => ConnectionInterface::LOCALE_DE,
            'region' => ConnectionInterface::REGION_US
        ));
        $data = $response->getData();

        $this->assertEquals(
            'http://us.battle.net/dynamic/path/HAHA/TWO/3?locale=de_DE&foo=DEF&bar=asd',
            $data['url']
        );
    }

    public function testTimestampToString()
    {
        $response = $this->obj->getStaticUrl(array(
            'lastmodified' => 1334305621,
            'url' => 'http://example.org/'
        ));
        $data     = $response->getData();

        $this->assertEquals('Fri, 13 Apr 2012 08:27:01 GMT', $data['lastmodified']);
    }
}