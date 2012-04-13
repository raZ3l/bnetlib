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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib\Resource\Wow\Configuration;

use bnetlib\UrlUtils;
use bnetlib\Exception\DomainException;
use bnetlib\Resource\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class ArenaTeam implements ConfigurationInterface
{
    /**
     * @const string
     */
    const RESOURCE_URL = '/api/wow/arena/%s/%s/%s';

    /**
     * @var int
     */
    protected $resourceType = self::TYPE_DYNAMIC_PATH;

    /**
     * @var array
     */
    protected $argumentAliases = array('realm' => 'slug');

    /**
     * @var array
     */
    protected $requiredArguments = array('realm', 'size', 'name');

    /**
     * @var null
     */
    protected $optionalArguments = null;

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
            'size' => function ($v) {
                if (!in_array($v, array('2v2', '3v3', '5v5'))) {
                    throw new DomainException(sprintf(
                        '%s is not a valid team size. Valid sizes are 2v2, 3v3 or 5v5', $v
                    ));
                }
                return $v;
            }
        );
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