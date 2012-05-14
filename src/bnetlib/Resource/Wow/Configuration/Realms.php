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

namespace bnetlib\Resource\Wow\Configuration;

use bnetlib\UrlUtils;
use bnetlib\Resource\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Realms implements ConfigurationInterface
{
    /**
     * @const string
     */
    const RESOURCE_URL = '/api/wow/realm/status';

    /**
     * @var int
     */
    protected $resourceType = self::TYPE_STATIC_PATH;

    /**
     * @var array
     */
    protected $argumentAliases = array('realms' => array('slug', 'realm'));

    /**
     * @var array
     */
    protected $optionalArguments = array('realms');

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
            'realms' => function ($v) {
                if (is_array($v)) {
                    foreach ($v as $i => $realm) {
                        $v[$i] = UrlUtils::slug($realm);
                    }
                    $v = implode(',', $v);
                }
                return $v;
            },
            'realm' => function ($v) {
                return UrlUtils::slug($v);
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
        return null;
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