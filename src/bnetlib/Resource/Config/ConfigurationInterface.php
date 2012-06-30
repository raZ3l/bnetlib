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
 * @subpackage Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Config;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
interface ConfigurationInterface
{
    /**#@+
     * @var integer
     */
    const TYPE_STATIC_URL   = 1;
    const TYPE_STATIC_PATH  = 2;
    const TYPE_DYNAMIC_URL  = 3;
    const TYPE_DYNAMIC_PATH = 4;
    /**#@-*/

    /**
     * @return boolean
     */
    public function isJson();

    /**
     * @return integer
     */
    public function getResourceType();

    /**
     * @return array|null
     */
    public function getArgumentAliases();

    /**
     * @return array|null
     */
    public function getRequiredArguments();

    /**
     * @return array|null
     */
    public function getOptionalArguments();

    /**
     * @return array|null
     */
    public function getManipulableArguments();

    /**
     * @return boolean
     */
    public function isAuthenticationPossible();
}