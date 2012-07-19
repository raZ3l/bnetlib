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
 * @subpackage Diablo3
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Entity\D3;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage Diablo3
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Career implements EntityInterface
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
     * @var array
     */
    protected $services = array(
        'heroes'      => 'shared.entity.listdata',
        'kills'       => 'd3.entity.career.kills',
        'time-played' => 'd3.entity.career.played',
        'artisan'     => 'd3.entity.career.artisan',
        'progression' => 'd3.entity.career.progression',
    );

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
    public function setResponseHeaders($headers)
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
     * @return Career\Heroes
     */
    public function getHeroes()
    {
        return $this->data['heroes'];
    }

    /**
     * @return Career\Heros
     */
    public function getFallenHeroes()
    {
        return $this->data['heroes'];
    }

    /**
     * @return Hero
     */
    public function getLastHeroPlayed()
    {
        return $this->data['heroes']->getLastPlayed();
    }

    /**
     * @return Career\Artisans
     */
    public function getArtisans()
    {
        return $this->data['artisan'];
    }

    /**
     * @return Career\Artisans
     */
    public function getHardcoreArtisans()
    {
        return $this->data['artisan'];
    }

    /**
     * @return Career\Progression
     */
    public function getProgression()
    {
        return $this->data['progression'];
    }

    /**
     * @return Career\Kills
     */
    public function getKills()
    {
        return $this->data['kills'];
    }

    /**
     * @return Career\Played
     */
    public function getPlayed()
    {
        return $this->data['time-played'];
    }

    /**
     * @return integer
     */
    public function getLastUpdated()
    {
        return $this->data['last-updated'];
    }
}