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

namespace bnetlib\Resource\Entity\Wow;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Achievement implements EntityInterface, \Iterator
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $services = array(
        'rewardItems' => 'wow.entity.item.reward',
        'criteria'    => 'wow.entity.achievements.criteria',
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
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;

        foreach ($this->services as $key => $service) {
            if (!empty($data[$key])) {
                foreach ($data[$key] as $i => $entry) {
                    $this->data[$key][$i] = $this->serviceLocator->get($service);
                    if (isset($this->headers)) {
                        $this->data[$key][$i]->setResponseHeaders($this->headers);
                    }
                    $this->data[$key][$i]->populate($entry);
                }
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
     * @inheritdoc
     */
    public function setServiceLocator(ServiceLocatorInterface $locator)
    {
        $this->serviceLocator = $locator;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->data['icon'];
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
        return !empty($this->data['hasCriteria']);
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->data['criteria'];
    }

    /**
     * @return boolean
     */
    public function hasReward()
    {
        return (isset($this->data['reward']) || !empty($this->data['rewardItems']));
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
    public function hasRewardItems()
    {
        return !empty($this->data['rewardItems']);
    }

    /**
     * @return array
     */
    public function getRewardItems()
    {
        return $this->data['rewardItems'];
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
     * @return Achievements\Criteria
     */
    public function current()
    {
        return $this->data['criteria'][$this->position];
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
        return isset($this->data['criteria'][$this->position]);
    }
}