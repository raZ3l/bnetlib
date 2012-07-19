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
 * @subpackage Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Entity\Shared;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ListData extends Data implements \Countable
{
    /**
     * @param  integer $id
     * @return boolean
     */
    public function has($id)
    {
        return in_array($id, $this->data);
    }

    /**
     * @see    \Countable
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }
}