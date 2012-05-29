<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\TestAssets;

use bnetlib\Resource\Config\ConfigurationInterface;

class DynamicPath implements ConfigurationInterface
{
    const RESOURCE_URL = '/dynamic/path/%s/%s/%s';

    protected $resourceType = self::TYPE_DYNAMIC_PATH;

    protected $argumentAliases = array('bar' => 'sdfsdf', 'foo' => array('fo', 'fooo'), 'two' => 'sec');

    protected $requiredArguments = array('one', 'two', 'three');

    protected $optionalArguments = array('foo', 'bar');

    protected $manipulableArguments = null;


    public function __construct()
    {
        $this->manipulableArguments = array(
            'fooo' => function ($v) {
                return strtoupper($v);
            },
            'one' => function ($v) {
                return strtoupper($v);
            },
            'sec' => function ($v) {
                return strtoupper($v);
            }
        );
    }

        /**
     * @inheritdoc
     */
    public function isJson()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * @inheritdoc
     */
    public function getArgumentAliases()
    {
        return $this->argumentAliases;
    }

    /**
     * @inheritdoc
     */
    public function getRequiredArguments()
    {
        return $this->requiredArguments;
    }

    /**
     * @inheritdoc
     */
    public function getOptionalArguments()
    {
        return $this->optionalArguments;
    }

    /**
     * @inheritdoc
     */
    public function getManipulableArguments()
    {
        return $this->manipulableArguments;
    }

    /**
     * @inheritdoc
     */
    public function isAuthenticationPossible()
    {
        return true;
    }
}