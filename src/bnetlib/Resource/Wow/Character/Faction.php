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
class Faction implements ResourceInterface
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
    public function populate(array $data)
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
     * @return int
     */
    public function getId()
    {
        return $this->data['id'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return int
     */
    public function getStanding()
    {
        return $this->data['standing'];
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->data['value'];
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->data['max'];
    }

    /**
     * @return boolean
     */
    public function isAtMax()
    {
        return $this->data['value'] === $this->data['max'];
    }

    /**
     * @return boolean
     */
    public function isExalted()
    {
        return $this->data['id'] === 7;
    }

    /**
     * @return boolean
     */
    public function isRevered()
    {
        return $this->data['id'] === 6;
    }

    /**
     * @return boolean
     */
    public function isHonored()
    {
        return $this->data['id'] === 5;
    }

    /**
     * @return boolean
     */
    public function isFriendly()
    {
        return $this->data['id'] === 4;
    }

    /**
     * @return boolean
     */
    public function isNeutral()
    {
        return $this->data['id'] === 3;
    }

    /**
     * @return boolean
     */
    public function isUnfriendly()
    {
        return $this->data['id'] === 2;
    }

    /**
     * @return boolean
     */
    public function isHostile()
    {
        return $this->data['id'] === 1;
    }

    /**
     * @return boolean
     */
    public function isHated()
    {
        return $this->data['id'] === 0;
    }
}