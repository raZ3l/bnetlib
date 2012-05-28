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

namespace bnetlib\Resource\Wow;

use bnetlib\Locale\LocaleInterface;
use bnetlib\Resource\ConsumeInterface;
use bnetlib\Locale\LocaleAwareInterface;
use bnetlib\Resource\Wow\Shared\GuildEmblem;
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
        'news'         => 'wow.guild.news',
        'members'      => 'wow.guild.members',
        'achievements' => 'wow.achievements.achievements',
    );

    /**
     * @var bnetlib\Locale\LocaleInterface
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
     * @var bnetlib\ServiceLocator\ServiceLocatorInterface
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
     * @return int
     */
    public function getLastModified()
    {
        return $this->data['lastModified'];
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
     * @return int
     */
    public function getLevel()
    {
        return $this->data['level'];
    }

    /**
     * @return int
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
     * @return int
     */
    public function getAchievementPoints()
    {
        return $this->data['achievementPoints'];
    }

    /**
     * @return bnetlib\Resource\Wow\Guild\Members|null
     */
    public function getMembers()
    {
        if (isset($this->data['members'])) {
            return $this->data['members'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Achievements\Achievements|nul
     */
    public function getAchievements()
    {
        if (isset($this->data['achievements'])) {
            return $this->data['achievements'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Achievements\News|nul
     */
    public function getNews()
    {
        if (isset($this->data['news'])) {
            return $this->data['news'];
        }

        return null;
    }
}