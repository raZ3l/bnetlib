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

namespace bnetlib\Resource\Wow\Guild;

use bnetlib\Resource\ResourceInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Reward implements ResourceInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $services = array(
        'item'        => 'wow.item.reward',
        'races'       => 'wow.shared.listdata',
        'achievement' => 'wow.achievements.achievement',

    );

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
     * @return int
     */
    public function getMinGuildLevel()
    {
        return $this->data['minGuildLevel'];
    }

    /**
     * @return int
     */
    public function getMinGuildStanding()
    {
        return $this->data['minGuildRepLevel'];
    }

    /**
     * @return bnetlib\Resource\Wow\Shared\ListData
     */
    public function getRaces()
    {
        return $this->data['races'];
    }

    /**
     * @return bnetlib\Resource\Wow\Item\Reward
     */
    public function getItem()
    {
        return $this->data['item'];
    }

    /**
     * @return bnetlib\Resource\Wow\Achievements\Achievement
     */
    public function geAchievement()
    {
        return $this->data['achievement'];
    }
}