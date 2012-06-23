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

use bnetlib\Exception\DomainException;
use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Icon implements ConfigurationInterface
{
    /**
     * @const string
     */
    const RESOURCE_URL = '/wow-assets/static/images/icons/%s/%s.jpg';

    /**
     * @var integer
     */
    protected $resourceType = self::TYPE_DYNAMIC_PATH;

    /**
     * @var array
     */
    protected $argumentAliases = array('size' => 'iconsize');

    /**
     * @var array
     */
    protected $requiredArguments = array('size', 'icon');

    /**
     * @var array
     */
    protected $manipulableArguments;

    /**
     * Setting closures.
     */
    public function __construct()
    {
        $size = function ($v) {
            if (!in_array((integer) $v, array(56, 36, 18))) {
                throw new DomainException(sprintf(
                    '%s is not a valid size. Valid sizes are 56, 36 or 18.', $v
                ));
            }
            return $v;
        };

        $this->manipulableArguments = array(
            'size'     => $size,
            'iconSize' => $size,
        );
    }


    /**
     * @inheritdoc
     */
    public function isJson()
    {
        return false;
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
        return false;
    }
}