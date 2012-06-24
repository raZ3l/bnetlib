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

use bnetlib\UrlUtils;
use bnetlib\Exception\DomainException;
use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ArenaLadder implements ConfigurationInterface
{
    /**
     * @const string
     */
    const RESOURCE_URL = '/api/wow/pvp/arena/%s/%s';

    /**
     * @var integer
     */
    protected $resourceType = self::TYPE_DYNAMIC_PATH;

    /**
     * @var array
     */
    protected $argumentAliases = array('battlegroup' => 'bgslug');

    /**
     * @var array
     */
    protected $requiredArguments = array('battlegroup', 'teamsize');

    /**
     * @var array
     */
    protected $optionalArguments = array('page', 'size', 'asc');

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
            'battlegroup' => function ($v) {
                        return UrlUtils::slug($v);
            },
            'teamsize' => function ($v) {
                if (!in_array($v, array('2v2', '3v3', '5v5'))) {
                    throw new DomainException(sprintf(
                        '%s is not a valid team size. Valid sizes are 2v2, 3v3 or 5v5', $v
                    ));
                }
                return $v;
            },
            'asc' => function ($v) {
                if (is_bool($v)) {
                    return ($v === true) ? 'true' : 'false';
                }
                return $v;
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