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

namespace bnetlib\Resource\Entity\Wow\Item;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Spell implements EntityInterface
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
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        unset($data['spellId']);

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
     * @inheritdoc
     */
    public function setServiceLocator(ServiceLocatorInterface $locator)
    {
        $this->serviceLocator = $locator;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->data['spell']['id'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['spell']['name'];
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->data['spell']['icon'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->data['spell']['description'];
    }

    /**
     * @return boolean
     */
    public function hasPowerCost()
    {
        return isset($this->data['spell']['powerCost']);
    }

    /**
     * @return string|null
     */
    public function getPowerCost()
    {
        if (isset($this->data['spell']['powerCost'])) {
            return $this->data['spell']['powerCost'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasCastTime()
    {
        return isset($this->data['spell']['castTime']);
    }

    /**
     * @return string|null
     */
    public function getCastTime()
    {
        if (isset($this->data['spell']['castTime'])) {
            return $this->data['spell']['castTime'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasCooldown()
    {
        return isset($this->data['spell']['cooldown']);
    }

    /**
     * @return string|null
     */
    public function getCooldown()
    {
        if (isset($this->data['spell']['cooldown'])) {
            return $this->data['spell']['cooldown'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasCharges()
    {
        return $this->data['nCharges'] > 0;
    }

    /**
     * @return integer
     */
    public function getCharges()
    {
        return $this->data['nCharges'];
    }

    /**
     * @return integer
     */
    public function getTrigger()
    {
        return $this->data['trigger'];
    }

    /**
     * @return boolean
     */
    public function isConsumable()
    {
        return $this->data['consumable'];
    }

    /**
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->data['categoryId'];
    }
}