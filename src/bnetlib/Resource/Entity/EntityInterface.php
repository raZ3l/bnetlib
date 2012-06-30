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
 * @package   Resource
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Entity;

use bnetlib\ServiceLocator\ServiceLocatorAwareInterface;

/**
 * @category  bnetlib
 * @package   Resource
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
interface EntityInterface extends ServiceLocatorAwareInterface
{
    /**
     * @return array
     */
    public function getResponseHeaders();

    /**
     * @param array $data
     */
    public function populate($data);

    /**
     * @param array $headers
     */
    public function setResponseHeaders($headers);

}