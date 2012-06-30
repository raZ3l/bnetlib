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
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Config\Wow;

use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Battlegroups implements ConfigurationInterface
{
    /**
     * @var string
     */
    const RESOURCE_URL = '/api/wow/data/battlegroups/';

    /**
     * @var integer
     */
    protected $resourceType = self::TYPE_STATIC_PATH;

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
        return null;
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
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getManipulableArguments()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function isAuthenticationPossible()
    {
        return true;
    }
}