<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
 *
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Entity\Wow;

use bnetlib\Resource\Entity\Wow\Shared\Character as BaseCharacter;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Character extends BaseCharacter
{
    /**
     * @var array
     */
    protected $services = array(
        'achievements' => 'wow.entity.achievements.achievements',
        'appearance'   => 'wow.entity.character.appearance',
        'companions'   => 'shared.entity.listdata',
        'feed'         => 'wow.entity.character.feed',
        'guild'        => 'wow.entity.character.guild',
        'items'        => 'wow.entity.character.items',
        'mounts'       => 'shared.entity.listdata',
        'pets'         => 'wow.entity.character.pets',
        'professions'  => 'wow.entity.character.professions',
        'progression'  => 'wow.entity.character.progression',
        'pvp'          => 'wow.entity.character.pvp',
        'quests'       => 'shared.entity.listdata',
        'reputation'   => 'wow.entity.character.reputation',
        'stats'        => 'wow.entity.character.stats',
        'talents'      => 'wow.entity.character.talents',
        'titles'       => 'wow.entity.character.titles'
    );

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        parent::populate($data);

        $this->data['lastmod']     = null;
        $this->data['lastModDate'] = null;

        if (isset($data['lastModified'])) {
            $this->data['lastModDate'] = new \DateTime(
                '@' . round(($data['lastModified'] / 1000), 0),
                new \DateTimeZone('UTC')
            );
            $this->data['lastmod'] = $data['lastModified'];
        }


        foreach ($this->services as $key => $service) {
            if (isset($data[$key])) {
                $array = $data[$key];

                if ($key === 'pvp') {
                    $array['realm'] = $data['realm'];
                }

                $this->data[$key] = $this->serviceLocator->get($service);
                if (isset($this->headers)) {
                    $this->data[$key]->setResponseHeaders($this->headers);
                }
                $this->data[$key]->populate($array);
            }
        }
    }

    /**
     * @return integer|null
     */
    public function getLastModified()
    {
        return $this->data['lastmod'];
    }

    /**
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->data['lastModDate'];
    }

    /**
     * @return Achievements\Achievements|null
     */
    public function getAchievements()
    {
        if (isset($this->data['achievements'])) {
            return $this->data['achievements'];
        }

        return null;
    }

    /**
     * @return Character\Appearance|null
     */
    public function getAppearance()
    {
        if (isset($this->data['appearance'])) {
            return $this->data['appearance'];
        }

        return null;
    }

    /**
     * @return Shared\ListData|null
     */
    public function getCompanions()
    {
        if (isset($this->data['companions'])) {
            return $this->data['companions'];
        }

        return null;
    }

    /**
     * @return Character\Guild|null
     */
    public function getGuild()
    {
        if (isset($this->data['guild'])) {
            return $this->data['guild'];
        }

        return null;
    }

    /**
     * @return Character\Feed|null
     */
    public function getFeed()
    {
        if (isset($this->data['feed'])) {
            return $this->data['feed'];
        }

        return null;
    }

    /**
     * @return Character\Items|null
     */
    public function getItems()
    {
        if (isset($this->data['items'])) {
            return $this->data['items'];
        }

        return null;
    }

    /**
     * @return Shared\ListData|null
     */
    public function getMounts()
    {
        if (isset($this->data['mounts'])) {
            return $this->data['mounts'];
        }

        return null;
    }

    /**
     * @return Character\Pets|null
     */
    public function getPets()
    {
        if (isset($this->data['pets'])) {
            return $this->data['pets'];
        }

        return null;
    }

    /**
     * @return Character\Professions|null
     */
    public function getProfessions()
    {
        if (isset($this->data['professions'])) {
            return $this->data['professions'];
        }

        return null;
    }

    /**
     * @return Character\Progression|null
     */
    public function getProgression()
    {
        if (isset($this->data['progression'])) {
            return $this->data['progression'];
        }

        return null;
    }

    /**
     * @return Character\Pvp|null
     */
    public function getPvp()
    {
        if (isset($this->data['pvp'])) {
            return $this->data['pvp'];
        }

        return null;
    }

    /**
     * @return Shared\ListData|null
     */
    public function getQuests()
    {
        if (isset($this->data['quests'])) {
            return $this->data['quests'];
        }

        return null;
    }

    /**
     * @return Character\Reputation|null
     */
    public function getReputation()
    {
        if (isset($this->data['reputation'])) {
            return $this->data['reputation'];
        }

        return null;
    }

    /**
     * @return Character\Stats|null
     */
    public function getStats()
    {
        if (isset($this->data['stats'])) {
            return $this->data['stats'];
        }

        return null;
    }

    /**
     * @return Character\Talents|null
     */
    public function getTalents()
    {
        if (isset($this->data['talents'])) {
            return $this->data['talents'];
        }

        return null;
    }

    /**
     * @return Character\Titles|null
     */
    public function getTitles()
    {
        if (isset($this->data['titles'])) {
            return $this->data['titles'];
        }

        return null;
    }

    /**
     * Returns the full name for a character, e.g. Coss the Insane.
     * If no title information is available or no title is selected,
     * the normal character name will be returned.
     *
     * @return string
     */
    public function getFullName()
    {
        if (isset($this->data['titles']) && $this->data['titles']->hasSelected()) {
            return sprintf($this->data['titles']->getSelected()->getTitle(), $this->data['name']);
        }

        return $this->data['name'];
    }
}