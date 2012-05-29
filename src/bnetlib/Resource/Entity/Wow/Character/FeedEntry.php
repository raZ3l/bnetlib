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

namespace bnetlib\Resource\Entity\Wow\Character;

use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class FeedEntry implements ConsumeInterface
{
    /**
     * @var array
     */
    protected $services = array(
        'criteria'    => 'wow.entity.achievements.criteria',
        'achievement' => 'wow.entity.achievements.dataachievement',
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
     * @var bnetlib\ServiceLocator\ServiceLocatorInterface
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
                $this->data[$key] = $this->serviceLocator->get($service);
                if (isset($this->headers)) {
                    $this->data[$key]->setResponseHeaders($this->headers);
                }
                $this->data[$key]->populate($data[$key]);
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
     * @inheritdoc
     */
    public function consume()
    {
        $consume = array();

        if (isset($this->data['itemId'])) {
            $consume['itemid'] = $this->data['itemId'];
        }

        return $consume;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->data['timestamp'];
    }

    /**
     * @return boolean
     */
    public function hasAchievement()
    {
        return isset($this->data['achievement']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Achievements\DataAchievement|null
     */
    public function getAchievement()
    {
        if (isset($this->data['achievement'])) {
            return $this->data['achievement'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasCriteria()
    {
        return isset($this->data['criteria']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Achievements\Criteria|null
     */
    public function getCriteria()
    {
        if (isset($this->data['criteria'])) {
            return $this->data['criteria'];
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getItemId()
    {
        if (isset($this->data['itemId'])) {
            return $this->data['itemId'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isFeatOfStrength()
    {
        return (isset($this->data['featOfStrength']) && $this->data['featOfStrength'] === true);
    }
}