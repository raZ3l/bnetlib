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

namespace bnetlib\Resource\Wow\Character;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
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
        return $this->data['standing'] === 7;
    }

    /**
     * @return boolean
     */
    public function isRevered()
    {
        return $this->data['standing'] === 6;
    }

    /**
     * @return boolean
     */
    public function isHonored()
    {
        return $this->data['standing'] === 5;
    }

    /**
     * @return boolean
     */
    public function isFriendly()
    {
        return $this->data['standing'] === 4;
    }

    /**
     * @return boolean
     */
    public function isNeutral()
    {
        return $this->data['standing'] === 3;
    }

    /**
     * @return boolean
     */
    public function isUnfriendly()
    {
        return $this->data['standing'] === 2;
    }

    /**
     * @return boolean
     */
    public function isHostile()
    {
        return $this->data['standing'] === 1;
    }

    /**
     * @return boolean
     */
    public function isHated()
    {
        return $this->data['standing'] === 0;
    }
}