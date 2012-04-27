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

namespace bnetlibTest\Resource\Wow\Configuration;

use bnetlibTest\Resource\SharedConfigurationTest;
use bnetlib\Resource\ConfigurationInterface;
use bnetlib\Resource\Wow\Configuration\CharacterClasses;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class CharacterClassesTest extends SharedConfigurationTest
{
    /**
     * @var CharacterClasses
     */
    protected $config;

    public function setUp()
    {
        $this->config = new CharacterClasses();
    }

    public function tearDown()
    {
        unset($this->config);
    }

    public function testResourceUrl()
    {
        if ($this->config->getResourceType() === ConfigurationInterface::TYPE_STATIC_URL) {
            $this->assertTrue(true);
            return;
        }

        if (defined('bnetlib\Resource\Wow\Configuration\CharacterClasses::RESOURCE_URL')) {
            if (!is_string(CharacterClasses::RESOURCE_URL)) {
                $this->fail('RESOURCE_URL must be a string.');
            }
        } else {
            $this->fail('Configurations for types other then TYPE_STATIC_URL must have RESOURCE_URL definded.');
        }

        $this->assertTrue(true);
    }
}