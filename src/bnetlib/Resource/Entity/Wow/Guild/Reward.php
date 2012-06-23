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

namespace bnetlib\Resource\Entity\Wow\Guild;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Reward implements EntityInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $services = array(
        'item'        => 'wow.entity.item.reward',
        'races'       => 'wow.entity.shared.listdata',
        'achievement' => 'wow.entity.achievements.achievement',

    );

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
            $this->data[$key] = $this->serviceLocator->get($service);
            if (isset($this->headers)) {
                $this->data[$key]->setResponseHeaders($this->headers);
            }
            $this->data[$key]->populate($data[$key]);
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
     * @return integer
     */
    public function getMinGuildLevel()
    {
        return $this->data['minGuildLevel'];
    }

    /**
     * @return integer
     */
    public function getMinGuildStanding()
    {
        return $this->data['minGuildRepLevel'];
    }

    /**
     * @return \bnetlib\Resource\Entity\Wow\Shared\ListData
     */
    public function getRaces()
    {
        return $this->data['races'];
    }

    /**
     * @return \bnetlib\Resource\Entity\Wow\Item\Reward
     */
    public function getItem()
    {
        return $this->data['item'];
    }

    /**
     * @return \bnetlib\Resource\Entity\Wow\Achievements\Achievement
     */
    public function geAchievement()
    {
        return $this->data['achievement'];
    }
}