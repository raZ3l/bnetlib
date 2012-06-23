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

namespace bnetlib\Resource\Entity\Wow\Achievements;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class DataAchievement implements EntityInterface
{
    /**
     * @var array
     */
    protected $services = array(
        'rewardItem' => 'wow.entity.item.reward',
        'criteria'   => 'wow.entity.achievements.criteria',
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
            if (isset($data[$key])) {
                if ($key !== 'criteria') {
                    $this->data[$key] = $this->serviceLocator->get($service);
                    if (isset($this->headers)) {
                        $this->data[$key]->setResponseHeaders($this->headers);
                    }
                    $this->data[$key]->populate($data[$key]);
                } else {
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
     * @return boolean
     */
    public function isAchievement()
    {
        return true;
    }

    /**
     * @return integer
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
     * @return integer
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
     * @return array|null
     */
    public function getCriteria()
    {
        if (isset($this->data['criteria'])) {
            return $this->data['criteria'];
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
     * @return \bnetlib\Resource\Entity\Wow\Item\Reward|null
     */
    public function getRewardItem()
    {
        if (isset($this->data['rewardItem'])) {
            return $this->data['rewardItem'];
        }

        return null;
    }
}