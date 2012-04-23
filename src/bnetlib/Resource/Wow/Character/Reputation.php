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
class Reputation implements ResourceInterface, \Iterator
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
    public function populate(array $data)
    {
        foreach ($data as $faction) {
            $this->index[$faction['id']] = $this->position;

            $this->data[$this->position] = new Faction();
            if (isset($this->headers)) {
                $this->data[$this->position]->setResponseHeaders($this->headers);
            }
            $this->data[$this->position]->populate($faction);

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
     * @param  int $id
     * @return boolean
     */
    public function hasEncountered($id)
    {
        return isset($this->index[$id]);
    }

    /**
     * @param  int $id
     * @return bnetlib\Resource\Wow\Character\Faction|null
     */
    public function getById($id)
    {
        if (isset($this->index[$id])) {
            return $this->data[$this->index[$id]];
        }

        return null;
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
     * @return bnetlib\Resource\Wow\Character\Faction
     */
    public function current()
    {
        return $this->data[$this->index[$this->position]];
    }

    /**
     * @see    \Iterator
     * @return string
     */
    public function key()
    {
        return $this->index[$this->position];
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
        return isset($this->index[$this->position]);
    }
}