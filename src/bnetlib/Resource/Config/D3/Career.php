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
 * @subpackage Diablo3
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Config\D3;

use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage Diablo3
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Career implements ConfigurationInterface
{
    /**
     * @const string
     */
    const RESOURCE_URL = '/api/d3/account/%s';

    /**
     * @var int
     */
    protected $resourceType = self::TYPE_DYNAMIC_PATH;

    /**
     * @var array
     */
    protected $requiredArguments = array('account');

    /**
     * @var array
     */
    protected $argumentAliases = array('account' => array('battletag', 'acc'));

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
            'battletag' => function ($v) {
                return str_replace('#', '-', $v);
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
        return null;
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