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

namespace bnetlibTest\Resource\Config;

use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
abstract class SharedConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testResourceUrl()
    {
        if ($this->config->getResourceType() === ConfigurationInterface::TYPE_STATIC_URL) {
            $this->assertTrue(true);
            return;
        }

        $class = get_class($this->config);

        if (defined($class . '::RESOURCE_URL')) {
            if (!is_string(constant($class . '::RESOURCE_URL'))) {
                $this->fail('RESOURCE_URL must be a string.');
            }
        } else {
            $this->fail('Configurations for types other then TYPE_STATIC_URL must have RESOURCE_URL definded.');
        }

        $this->assertTrue(true);
    }

    public function testResourceType()
    {
        $types = array(
            ConfigurationInterface::TYPE_STATIC_URL,
            ConfigurationInterface::TYPE_STATIC_PATH,
            ConfigurationInterface::TYPE_DYNAMIC_URL,
            ConfigurationInterface::TYPE_DYNAMIC_PATH
        );

        if (!in_array($this->config->getResourceType(), $types)) {
            $this->fail('Invalid resource type.');
        }

        $this->assertTrue(true);
    }

    public function testAuthentication()
    {
        if (!is_bool($this->config->isAuthenticationPossible())) {
            $this->fail('Authentication value must be a boolean.');
        }

        $this->assertTrue(true);
    }

    public function testIsJson()
    {
        if (!is_bool($this->config->isJson())) {
            $this->fail('Is Json must return a boolean.');
        }

        $this->assertTrue(true);
    }

    public function testArgumentAliases()
    {
        $aliases = $this->config->getArgumentAliases();

        if ($aliases === null) {
            $this->assertTrue(true);
            return;
        }

        if (!is_array($aliases)) {
            $this->fail('Argument aliases must be an array or null.');
        }

        $this->assertTrue(true);
    }

    /**
     * @depends testArgumentAliases
     */
    public function testArgumentAliasesDefinition()
    {
        $aliases = $this->config->getArgumentAliases();

        if ($aliases === null || empty($aliases)) {
            $this->assertTrue(true);
            return;
        }

        foreach ($aliases as $alias) {
            if (is_array($alias)) {
                if (array_values($alias) !== $alias) {
                    $this->fail('Alias must be a list.');
                }
                foreach ($alias as $name) {
                    if (!is_string($name)) {
                        $this->fail('Alias value in array must be a string.');
                    }
                }
            } elseif (!is_string($alias)) {
                $this->fail('Alias must be an array or string.');
            }
        }

        $this->assertTrue(true);
    }

    public function testRequiredArguments()
    {
        $notNull = array(
            ConfigurationInterface::TYPE_DYNAMIC_URL,
            ConfigurationInterface::TYPE_DYNAMIC_PATH
        );
        $required = $this->config->getRequiredArguments();

        if (in_array($this->config->getResourceType(), $notNull) && $required === null) {
            $this->fail('Dynamic resources must require at least one argument.');
        }

        if ($required === null) {
            $this->assertTrue(true);
            return;
        }

        if (!is_array($required)) {
            $this->fail('Optional arguments must be an array or null.');
        }

        $this->assertTrue(true);
    }

    /**
     * @depends testRequiredArguments
     */
    public function testRequiredArgumentsIsList()
    {
        $required = $this->config->getRequiredArguments();

        if ($required === null || empty($required)) {
            $this->assertTrue(true);
            return;
        }

        if (array_values($required) !== $required) {
            $this->fail('Required arguments must be a list.');
        }

        $this->assertTrue(true);
    }

    public function testOptionalArguments()
    {
        $optional = $this->config->getOptionalArguments();

        if ($optional === null) {
            $this->assertTrue(true);
            return;
        }

        if (!is_array($optional)) {
            $this->fail('Optional arguments must be an array or null.');
        }

        $this->assertTrue(true);
    }

    /**
     * @depends testOptionalArguments
     */
    public function testOptionalArgumentsIsList()
    {
        $optional = $this->config->getOptionalArguments();

        if ($optional === null || empty($optional)) {
            $this->assertTrue(true);
            return;
        }

        if (array_values($optional) !== $optional) {
            $this->fail('Required arguments must be a list.');
        }

        $this->assertTrue(true);
    }

    /**
     * @depends testArgumentAliasesDefinition
     */
    public function testArgumentAliasesInConfigScope()
    {
        $aliases = $this->config->getArgumentAliases();

        if ($aliases === null || empty($aliases)) {
            $this->assertTrue(true);
            return;
        }

        $required    = $this->config->getRequiredArguments();
        $optional    = $this->config->getOptionalArguments();
        $required    = ($required === null) ? array() : $required;
        $optional    = ($optional === null) ? array() : $optional;
        $whitelist   = array_merge($required, $optional);

        foreach ($aliases as $original => $alias) {
            if (!in_array($original, $whitelist)) {
                $this->fail('Only names within the configuration scope can use an alias.');
            }
        }

        $this->assertTrue(true);
    }

    /**
     * @depends testArgumentAliasesDefinition
     */
    public function testArgumentAliasesAliasConflict()
    {
        $registry = array();
        $aliases  = $this->config->getArgumentAliases();

        if ($aliases === null || empty($aliases)) {
            $this->assertTrue(true);
            return;
        }

        foreach ($aliases as $alias) {
            if (is_array($alias)) {
                foreach ($alias as $name) {
                    if (in_array($name, $registry)) {
                        $this->fail('Alias already definined.');
                    }
                    $registry[] = $name;
                }
            } else {
                if (in_array($alias, $registry)) {
                    $this->fail('Alias already definined.');
                }
                $registry[] = $alias;
            }
        }

        $this->assertTrue(true);
    }

    public function testManipulableArguments()
    {
        $manipulable = $this->config->getManipulableArguments();

        if ($manipulable === null) {
            $this->assertTrue(true);
            return;
        }

        if (!is_array($manipulable)) {
            $this->fail('Optional arguments must be an array or null.');
        }

        $this->assertTrue(true);
    }

    /**
     * @depends testManipulableArguments
     */
    public function testManipulableArgumentsUsesClosure()
    {
        $manipulable = $this->config->getManipulableArguments();

        if ($manipulable === null || empty($manipulable)) {
            $this->assertTrue(true);
            return;
        }

        foreach ($manipulable as $name => $closure) {
            if (!$closure instanceof \Closure) {
                $this->fail('A closure must be supplied to manipulate values.');
            }
        }

        $this->assertTrue(true);
    }

    /**
     * @depends testRequiredArguments
     * @depends testOptionalArguments
     * @depends testManipulableArguments
     * @depends testArgumentAliasesDefinition
     */
    public function testManipulableArgumentsInConfigScope()
    {
        $manipulable = $this->config->getManipulableArguments();

        if ($manipulable === null || empty($manipulable)) {
            $this->assertTrue(true);
            return;
        }

        #$specials  = array('url', 'locale', 'region', 'lastmodified');
        $aliases   = $this->config->getArgumentAliases();
        $required  = $this->config->getRequiredArguments();
        $optional  = $this->config->getOptionalArguments();
        $aliases   = ($aliases === null) ? array() : $aliases;
        $required  = ($required === null) ? array() : $required;
        $optional  = ($optional === null) ? array() : $optional;
        $whitelist = array_merge($required, $optional);

        foreach ($aliases as $alias) {
            if (is_array($alias)) {
                foreach ($alias as $name) {
                    $whitelist[] = $name;
                }
            } else {
                $whitelist[] = $alias;
            }
        }

        foreach ($manipulable as $name => $value) {
            if (!in_array($name, $whitelist)) {
                $this->fail(sprintf(
                    'Only data within the configuration scope should be manipulated (%s).',
                    $name
                ));
            }
        }

        $this->assertTrue(true);
    }
}