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

namespace bnetlib\Resource\Entity\Wow\Realms;

use bnetlib\Locale\LocaleInterface;
use bnetlib\Locale\LocaleAwareInterface;
use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class PvpArea implements EntityInterface, LocaleAwareInterface
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
     * @var LocaleInterface
     */
    protected $locale;

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

        $next = new \DateTime('@' . round(($data['next'] / 1000), 0), new \DateTimeZone('UTC'));
        $this->data['nextDate'] = $next;
        $this->data['next']     = $data['next'];
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
    public function setLocale(LocaleInterface $locale)
    {
        $this->locale = $locale;

        return $this;
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
    public function getArea()
    {
        return $this->data['area'];
    }

    /**
     * @return integer
     */
    public function getControllingFaction()
    {
        return $this->data['controlling-faction'];
    }

    /**
     * @return string|null
     */
    public function getControllingFactionLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('faction.%s', $this->data['controlling-faction']), 'wow');
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isAllianceControlled()
    {
        return $this->data['controlling-faction'] === 0;
    }

    /**
     * @return boolean
     */
    public function isHordeControlled()
    {
        return $this->data['controlling-faction'] === 1;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->data['status'];
    }

    /**
     * @return string|null
     */
    public function getStatusLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('pvpareastatus.%s', $this->data['status']), 'wow');
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isIdle()
    {
        return $this->data['status'] === 0;
    }

    /**
     * @return boolean
     */
    public function isPopulating()
    {
        return $this->data['status'] === 1;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->data['status'] === 2;
    }

    /**
     * @return boolean
     */
    public function isConcluded()
    {
        return $this->data['status'] === 3;
    }

    /**
     * @return integer
     */
    public function getNext()
    {
        return $this->data['next'];
    }

    /**
     * Returns "next" as DateTime object.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->data['nextDate'];
    }
}