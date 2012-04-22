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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib\Resource\Wow\Character;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Pets implements ResourceInterface, \Iterator, \Countable
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var int|null
     */
    protected $selected;

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
    public function populate(array $data)
    {
        foreach ($data as $i => $pet) {
            if (isset($pet['selected'])) {
                $this->slected = $i;
            }

            $this->data[$i] = new Pet();
            if (isset($this->headers)) {
                $this->data[$i]->setResponseHeaders($this->headers);
            }
            $this->data[$i]->populate($pet);
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
     * @see    \Countable
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @return boolean
     */
    public function hasSelected()
    {
        return isset($this->selected);
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Pet
     */
    public function getSelected()
    {
        return $this->data[$this->selected];
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
     * @return bnetlib\Resource\Wow\Character\Pet
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