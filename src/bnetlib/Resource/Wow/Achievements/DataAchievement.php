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

namespace bnetlib\Resource\Wow\Achievements;

use bnetlib\Resource\Wow\Item\Reward;
use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class DataAchievement implements ResourceInterface
{
    /**
     * @var array
     */
    protected $fields = array(
        'rewardItem' => 'bnetlib\Resource\Wow\Item\Reward',
        'criteria'   => 'bnetlib\Resource\Wow\Achievements\Criteria',
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
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;

        foreach ($this->fields as $field => $class) {
            if (isset($data[$field])) {
                $this->data[$field] = new $class();
                if (isset($this->headers)) {
                    $this->data[$field]->setResponseHeaders($this->headers);
                }
                $this->data[$field]->populate($data[$field]);
            }
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
     * @return boolean
     */
    public function isAchievement()
    {
        return true;
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
        return $this->data['title'];
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->data['points'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    /**
     * @return boolean
     */
    public function hasCriteria()
    {
        return isset($this->data['hasCriteria']);
    }

    /**
     * @return bnetlib\Resource\Wow\Achievements\Criteria|null
     */
    public function getCriteria()
    {
        if (isset($this->data['Criteria'])) {
            return $this->data['Criteria'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasReward()
    {
        return (isset($this->data['reward']) || isset($this->data['rewardItem']));
    }

    /**
     * @return boolean
     */
    public function hasRewardString()
    {
        return isset($this->data['reward']);
    }

    /**
     * @return string|null
     */
    public function getReward()
    {
        if (isset($this->data['reward'])) {
            return $this->data['reward'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasRewardItem()
    {
        return isset($this->data['rewardItem']);
    }

    /**
     * @return bnetlib\Resource\Wow\Item\Reward|null
     */
    public function getRewardItem()
    {
        if (isset($this->data['rewardItem'])) {
            return $this->data['rewardItem'];
        }

        return null;
    }
}