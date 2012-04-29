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

namespace bnetlib\Resource\Wow;

use bnetlib\Resource\ConsumeInterface;
use bnetlib\Resource\ResourceInterface;
use bnetlib\Resource\Wow\Auction\Faction;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class AuctionData implements ResourceInterface, ConsumeInterface, \Iterator
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $index = array();

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
        foreach ($data as $key => $value) {
            if ($key === 'realm') {
                $this->data[$key] = $value;
                continue;
            }

            $this->index[$key] = $this->position;

            $this->data['f'][$this->position] = new Faction();
            if (isset($this->headers)) {
                $this->data['f'][$this->position]->setResponseHeaders($this->headers);
            }
            $this->data['f'][$this->position]->populate($value['auctions']);

            $this->position++;
        }

        $this->position = 0;
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
     * @return string
     */
    public function getRealm()
    {
        return $this->data['realm']['name'];
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->data['realm']['slug'];
    }

    /**
     * @return bnetlib\Resource\Wow\Auction\Faction
     */
    public function getAlliance()
    {
        return $this->data['f'][$this->index['alliance']];
    }

    /**
     * @return bnetlib\Resource\Wow\Auction\Faction
     */
    public function getHorde()
    {
        return $this->data['f'][$this->index['horde']];
    }

    /**
     * @return bnetlib\Resource\Wow\Auction\Faction
     */
    public function getNeutral()
    {
        return $this->data['f'][$this->index['neutral']];
    }

    /**
     * @inheritdoc
     */
    public function consume()
    {
        return array('slug' => $this->data['realm']['slug']);
    }

    /**
     * @see \Iterator
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @see    \Iterator
     * @return bnetlib\Resource\Wow\Auction\Faction
     */
    public function current()
    {
        return $this->data['f'][$this->position];
    }

    /**
     * @see    \Iterator
     * @return string
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @see \Iterator
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @see    \Iterator
     * @return boolean
     */
    public function valid()
    {
        return isset($this->data['f'][$this->position]);
    }
}