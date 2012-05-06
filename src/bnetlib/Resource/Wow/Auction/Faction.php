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
use bnetlib\Exception\InvalidArgumentException;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Faction implements ResourceInterface, \Iterator
{
    /**#@+
     * @const int
     */
    const TIME_SHORT     = 1;
    const TIME_MEDIUM    = 2;
    const TIME_LONG      = 3;
    const TIME_VERY_LONG = 4;
    /**#@-*/

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $index = array(
        'item' => array(),
        'time' => array()
    );

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var \stdClass|null
     */
    protected $headers;

    /**
     * @var array
     */
    protected $timeMap = array(
        'SHORT'     => 1,
        'MEDIUM'    => 2,
        'LONG'      => 3,
        'VERY_LONG' => 4
    );

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        foreach ($data as $i => $auction) {
            $auction['time'] = $this->timeMap[$auction['timeLeft']];

            $this->index['item'][$auction['item']][] = $i;
            $this->index['time'][$auction['time']][] = $i;

            $this->data[$i] = new Auction();
            if (isset($this->headers)) {
                $this->data[$i]->setResponseHeaders($this->headers);
            }
            $this->data[$i]->populate($auction);
        }
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
     * @param  int $id
     * @return array
     */
    public function getByItem($id)
    {
        if (!isset($this->index['item'][$id])) {
            return array();
        }

        $result = array();
        foreach ($this->index['item'][$id] as $i) {
            $result[] = $this->data[$i];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getItemIndex()
    {
        $result = array();
        foreach ($this->index['item'] as $id => $index) {
            $result[$id] = array();
            foreach ($index as $i) {
                $result[$id][] = $this->data[$i];
            }
        }

        return $result;
    }

    /**
     * @param  string|int $phrase
     * @throws bnetlib\Exception\InvalidArgumentException
     * @throws bnetlib\Exception\InvalidArgumentException
     * @return array
     */
    public function getByTime($phrase)
    {
        if (is_string($phrase)) {
            $phrase = strtoupper($phrase);
            if (!isset($this->timeMap[$phrase])) {
                throw new InvalidArgumentException(sprintf('%s is not a valid time phrase.', $phrase));
            } else {
                $phrase = $this->timeMap[$phrase];
            }
        } elseif (!is_numeric($phrase)) {
            throw new InvalidArgumentException(sprintf(
                'A time phrase must be an array or string, %s given.', gettype($phrase)
            ));
        }

        if (!isset($this->index['time'][$phrase])) {
            return array();
        }

        $result = array();
        foreach ($this->index['time'][$phrase] as $i) {
            $result[] = $this->data[$i];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getTimeIndex()
    {
        $result = array();
        foreach ($this->index['time'] as $phrase => $index) {
            $result[$phrase] = array();
            foreach ($index as $i) {
                $result[$phrase][] = $this->data[$i];
            }
        }

        return $result;
    }

    /**
     * @param  int    $id
     * @param  string $phrase
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidArgumentException
     * @return array
     */
    public function getItemAndTimeIntersection($id, $phrase)
    {
        if (is_string($phrase)) {
            $phrase = strtoupper($phrase);
            if (!isset($this->timeMap[$phrase])) {
                throw new Exception\InvalidArgumentException(sprintf('%s is not a valid time phrase.', $phrase));
            } else {
                $phrase = $this->timeMap[$phrase];
            }
        } elseif (!is_numeric($phrase)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'A time phrase must be an array or string, %s given.', gettype($phrase)
            ));
        }

        if (!isset($this->index['item'][$id]) || !isset($this->index['time'][$phrase])) {
            return array();
        }

        $result = array();
        foreach ($this->index['item'][$id] as $i) {
            if (in_array($i, $this->index['time'][$phrase])) {
                $result[] = $this->data[$i];
            }
        }

        return $result;
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
     * @return bnetlib\Resource\Wow\Auction\Auction
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * @see    \Iterator
     * @return int
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
        return isset($this->data[$this->position]);
    }
}