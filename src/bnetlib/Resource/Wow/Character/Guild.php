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

use bnetlib\Resource\ConsumeInterface;
use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Guild implements ResourceInterface, ConsumeInterface, \Countable
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
        return $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return string
     */
    public function getRealm()
    {
        return $this->data['realm'];
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->data['level'];
    }

    /**
     * @return int
     */
    public function getMembers()
    {
        return $this->data['members'];
    }

    /**
     * @see    \Countable
     * @return int
     */
    public function count()
    {
        return $this->data['members'];
    }

    /**
     * @return int
     */
    public function getAchievementPoints()
    {
        return $this->data['achievementPoints'];
    }

    /**
     * @return array
     */
    public function getEmblem()
    {
        return $this->data['emblem'];
    }

    /**
     * @return int
     */
    public function getEmblemIcon()
    {
        return $this->data['emblem']['icon'];
    }

    /**
     * @return string
     */
    public function getEmblemIconColor()
    {
        return $this->data['emblem']['iconColor'];
    }

    /**
     * @return int
     */
    public function getEmblemBorder()
    {
        return $this->data['emblem']['border'];
    }

    /**
     * @return string
     */
    public function getEmblemBorderColor()
    {
        return $this->data['emblem']['borderColor'];
    }

    /**
     * @return string
     */
    public function getEmblemBackgroundColor()
    {
        return $this->data['emblem']['backgroundColor'];
    }

    /**
     * @inheritdoc
     */
    public function consume()
    {
        return array(
            'guild' => $this->data['name'],
            'realm' => $this->data['realm']
        );
    }
}