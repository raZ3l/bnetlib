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
class Titles implements ResourceInterface, \Iterator
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $selected = null;

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
        foreach ($data as $key => $title) {
            if ($key === 'name') {
                continue;
            }

            if (isset($data['name'])) {
                $title['character'] = $data['name'];
            }

            $class = new Title();
            if (isset($this->headers)) {
                $class->setResponseHeaders($this->headers);
            }
            $class->populate($title);
            $this->data[$this->position] = $class;

            if (isset($title['selected'])) {
                $this->selected = $this->position;
            }

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
     * @return boolean
     */
    public function hasSelected()
    {
        return $this->selected !== null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Title|null
     */
    public function getSelected()
    {
        if ($this->selected === null) {
            return null;
        }

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
     * @return bnetlib\Resource\Wow\Character\Title
     */
    public function current()
    {
        return $this->data[$this->position];
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
        return isset($this->data[$this->position]);
    }
}