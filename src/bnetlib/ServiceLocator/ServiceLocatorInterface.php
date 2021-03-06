<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
 *
 * @category  bnetlib
 * @package   ServiceLocator
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\ServiceLocator;

/**
 * @category  bnetlib
 * @package   ServiceLocator
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
interface ServiceLocatorInterface
{
    /**
     * @param  string  $name
     * @return boolean
     */
    public function has($name);

    /**
     * @param  string  $name
     * @param  boolean $shared
     * @return object
     */
    public function get($name, $shared = false);
}