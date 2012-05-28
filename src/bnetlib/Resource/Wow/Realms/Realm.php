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

namespace bnetlib\Resource\Wow\Realms;

use bnetlib\Resource\ResourceInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Realm implements ResourceInterface
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
     * @var bnetlib\ServiceLocator\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;

        foreach (array('wintergrasp', 'tol-barad') as $key) {
            $class = $this->serviceLocator->get('wow.realms.pvparea');
            if (isset($this->headers)) {
                $class->setResponseHeaders($this->headers);
            }
            $class->populate($this->data[$key]);

            $this->data[$key] = $class;
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
     * @return string
     */
    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * @return string
     */
    public function getPopulation()
    {
        return $this->data['population'];
    }

    /**
     * @return boolean
     */
    public function getQueue()
    {
        return $this->data['queue'];
    }

    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->data['status'];
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
    public function getSlug()
    {
        return $this->data['slug'];
    }

    /**
     * @return string
     */
    public function getBattlegroup()
    {
        return $this->data['battlegroup'];
    }

    /**
     * @return bnetlib\Resource\Wow\Realms\PvpArea
     */
    public function getWintergrasp()
    {
        return $this->data['wintergrasp'];
    }

    /**
     * @return bnetlib\Resource\Wow\Realms\PvpArea
     */
    public function getTolBarad()
    {
        return $this->data['tol-barad'];
    }

    /**
     * @return boolean
     */
    public function isPvpRealm()
    {
        return $this->data['type'] === 'pvp';
    }

    /**
     * @return boolean
     */
    public function isPveRealm()
    {
        return $this->data['type'] === 'pve';
    }

    /**
     * @return boolean
     */
    public function isRpPvpRealm()
    {
        return $this->data['type'] === 'rppvp';
    }

    /**
     * @return boolean
     */
    public function isRpPveRealm()
    {
        return $this->data['type'] === 'rp';
    }

    /**
     * @return boolean
     */
    public function isRpRealm()
    {
        return substr($this->data['type'], 0, 2) === 'rp';
    }

    /**
     * @return boolean
     */
    public function isLowlyPopulated()
    {
        return $this->data['population'] === 'low';
    }

    /**
     * @return boolean
     */
    public function isMediumPopulated()
    {
        return $this->data['population'] === 'medium';
    }

    /**
     * @return boolean
     */
    public function isHighlyPopulated()
    {
        return $this->data['population'] === 'high';
    }

    /**
     * @return boolean
     */
    public function isOnline()
    {
        return $this->data['status'];
    }

    /**
     * @return boolean
     */
    public function hasQueue()
    {
        return $this->data['queue'];
    }
}