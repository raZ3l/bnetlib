<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @category  bnetlib
 * @package   Resource
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource;

/**
 * @category  bnetlib
 * @package   Resource
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
interface ConsumeInterface extends ResourceInterface
{
    /**
     * @return array
     */
    public function consume();
}