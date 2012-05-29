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
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Config\Wow;

use bnetlib\UrlUtils;
use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Guild implements ConfigurationInterface
{
    /**
     * @const string
     */
    const RESOURCE_URL = '/api/wow/guild/%s/%s';

    /**
     * @var int
     */
    protected $resourceType = self::TYPE_DYNAMIC_PATH;

    /**
     * @var array
     */
    protected $argumentAliases = array('realm' => 'slug', 'name' => 'guild');

    /**
     * @var array
     */
    protected $requiredArguments = array('realm', 'name');

    /**
     * @var array
     */
    protected $optionalArguments = array('fields');

    /**
     * @var array
     */
    protected $manipulableArguments;

    /**
     * Setting closures.
     */
    public function __construct()
    {
        $this->manipulableArguments = array(
            'realm' => function ($v) {
                return UrlUtils::slug($v);
            },
            'fields' => function ($v) {
                return (is_array($v)) ? implode(',', $v) : $v;
            },
            'name' => function ($v) {
                return rawurlencode($v);
            },
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