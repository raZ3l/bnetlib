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
 * @package    Connection
 * @subpackage UnitTests
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\Locale;

use bnetlib\Locale\Locale;

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
    protected $locale;

    public function setUp()
    {
        $this->locale = new Locale('de_DE', 'test');
        $this->locale->setFile(__DIR__ . '%1$sfixtures%1$s%2$s%1$s%3$s.php');
    }

    public function tearDown()
    {
        unset($this->locale);
    }

    public function testFooBarDe()
    {
        $this->assertEquals('FooBar_DE', $this->locale->get('foo.bar'));
        $this->assertEquals('BarFoo_DE', $this->locale->get('bar.foo'));
    }

    public function testFooBarGb()
    {
        $this->locale->setLocale('en_GB');
        $this->assertEquals('FooBar_GB', $this->locale->get('foo.bar'));
        $this->assertEquals('BarFoo_GB', $this->locale->get('bar.foo'));
    }

    public function testFooBarDeWithGbLocale()
    {
        $this->locale->setLocale('en_GB');
        $this->assertNotEquals('FooBar_DE', $this->locale->get('foo.bar'));
        $this->assertNotEquals('BarFoo_DE', $this->locale->get('bar.foo'));
    }
}