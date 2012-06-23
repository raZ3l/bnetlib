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

use bnetlib\Locale\LocaleInterface;
use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\Locale\LocaleAwareInterface;
use bnetlib\Resource\Entity\Wow\Shared\GuildEmblem;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Guild extends GuildEmblem implements ConsumeInterface, LocaleAwareInterface
{
    /**
     * @var array
     */
    protected $services = array(
        'news'         => 'wow.entity.guild.news',
        'members'      => 'wow.entity.guild.members',
        'achievements' => 'wow.entity.achievements.achievements',
    );

    /**
     * @var LocaleInterface
     */
    protected $locale;

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
        $this->data =  $data;

        foreach ($this->services as $key => $service) {
            if (isset($data[$key])) {
                $this->data[$key] = $this->serviceLocator->get($service);
                if (isset($this->headers)) {
                    $this->data[$key]->setResponseHeaders($this->headers);
                }
                $this->data[$key]->populate($data[$key]);
            }
        }

        $this->data['date'] = new \DateTime(
            '@' . round(($data['lastModified'] / 1000), 0),
            new \DateTimeZone('UTC')
        );

        foreach ($data['emblem'] as $key => $value) {
            $this->data[$key] = $value;
        }

        unset($this->data['emblem']);
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
    public function setLocale(LocaleInterface $locale)
    {
        $this->locale = $locale;

        foreach ($this->data as $key => $value) {
            if (is_object($value) && $value instanceof LocaleAwareInterface) {
                $this->data[$key]->setLocale($locale);
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function consume()
    {
        return array('realm' => $this->data['realm']);
    }

    /**
     * @return integer
     */
    public function getLastModified()
    {
        return $this->data['lastModified'];
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->data['date'];
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
    public function getRealm()
    {
        return $this->data['realm'];
    }

    /**
     * @return integer
     */
    public function getLevel()
    {
        return $this->data['level'];
    }

    /**
     * @return integer
     */
    public function getFaction()
    {
        return $this->data['side'];
    }

    /**
     * @return string|null
     */
    public function getFactionLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('faction.%s', $this->data['side']), 'wow');
        }

        return null;
    }

    /**
     * @return integer
     */
    public function getAchievementPoints()
    {
        return $this->data['achievementPoints'];
    }

    /**
     * @return Guild\Members|null
     */
    public function getMembers()
    {
        if (isset($this->data['members'])) {
            return $this->data['members'];
        }

        return null;
    }

    /**
     * @return Achievements\Achievements|nul
     */
    public function getAchievements()
    {
        if (isset($this->data['achievements'])) {
            return $this->data['achievements'];
        }

        return null;
    }

    /**
     * @return Guild\News|nul
     */
    public function getNews()
    {
        if (isset($this->data['news'])) {
            return $this->data['news'];
        }

        return null;
    }
}