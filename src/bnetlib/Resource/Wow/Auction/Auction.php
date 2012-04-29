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

namespace bnetlib\Resource\Wow\Auction;

use bnetlib\Resource\ConsumeInterface;
use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Auction implements ResourceInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var \stdClass|null
     */
    protected $headers;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getResponseHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritdoc
     */
    public function setResponseHeaders(\stdClass $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return boolean
     */
    public function isShort()
    {
        return $this->data['time'] === 1;
    }

    /**
     * @return boolean
     */
    public function isMedium()
    {
        return $this->data['time'] === 2;
    }

    /**
     * @return boolean
     */
    public function isLong()
    {
        return $this->data['time'] === 3;
    }

    /**
     * @return boolean
     */
    public function isVeryLong()
    {
        return $this->data['time'] === 4;
    }

    /**
     * @return int
     */
    public function getAuctionId()
    {
        return $this->data['auc'];
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->data['item'];
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->data['owner'];
    }

    /**
     * @return int
     */
    public function getBid()
    {
        return $this->data['bid'];
    }

    /**
     * @return int
     */
    public function getBuyout()
    {
        return $this->data['buyout'];
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->data['quantity'];
    }

    /**
     * @return int 1 = Short, 2 = Medium, 3 = Long and 4 = Very Long
     */
    public function getTimeLeft()
    {
        return $this->data['time'];
    }
}