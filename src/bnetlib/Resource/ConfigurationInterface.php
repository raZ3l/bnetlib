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
 * @subpackage Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib\Resource;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
interface ConfigurationInterface
{
    /**#@+
     * @const int
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
     * @return int
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