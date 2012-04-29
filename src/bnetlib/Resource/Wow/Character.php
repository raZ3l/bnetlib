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

use bnetlib\Resource\Wow\Shared\Character as BaseCharacter;

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
    protected $fields = array(
        'achievements' => 'bnetlib\Resource\Wow\Achievements\Achievements',
        'appearance'   => 'bnetlib\Resource\Wow\Character\Appearance',
        'companions'   => 'bnetlib\Resource\Wow\Shared\ListData',
        'guild'        => 'bnetlib\Resource\Wow\Character\Guild',
        'items'        => 'bnetlib\Resource\Wow\Character\Items',
        'mounts'       => 'bnetlib\Resource\Wow\Shared\ListData',
        'pets'         => 'bnetlib\Resource\Wow\Character\Pets',
        'professions'  => 'bnetlib\Resource\Wow\Character\Professions',
        'progression'  => 'bnetlib\Resource\Wow\Character\Progression',
        'pvp'          => 'bnetlib\Resource\Wow\Character\Pvp',
        'quests'       => 'bnetlib\Resource\Wow\Shared\ListData',
        'reputation'   => 'bnetlib\Resource\Wow\Character\Reputation',
        'stats'        => 'bnetlib\Resource\Wow\Character\Stats',
        'talents'      => 'bnetlib\Resource\Wow\Character\Talents',
        'titles'       => 'bnetlib\Resource\Wow\Character\Titles'
    );

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        parent::populate($data);

        $this->data['lastmod'] = null;
        if (isset($data['lastModified'])) {
            $this->data['lastmod'] = $data['lastModified'];
        }

        foreach ($this->fields as $field => $class) {
            if (isset($data[$field])) {
                $array = $data[$field];

                switch ($field) {
                    case 'pvp':
                        $array['realm'] = $data['realm'];
                        break;
                    case 'titles':
                        $array['name'] = $data['name'];
                        break;
                }

                $this->data[$field] = new $class();
                if (isset($this->headers)) {
                    $this->data[$field]->setResponseHeaders($this->headers);
                }
                $this->data[$field]->populate($array);
            }
        }

        unset($this->fields);
    }

    /**
     * @return int|null Last modification (UTC unix timestamp)
     */
    public function getLastModified()
    {
        return $this->data['lastmod'];
    }

    /**
     * @return bnetlib\Resource\Wow\Shared\Achievements|null
     */
    public function getAchievements()
    {
        if (isset($this->data['achievements'])) {
            return $this->data['achievements'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Appearance|null
     */
    public function getAppearance()
    {
        if (isset($this->data['appearance'])) {
            return $this->data['appearance'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Shared\ListData|null
     */
    public function getCompanions()
    {
        if (isset($this->data['companions'])) {
            return $this->data['companions'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Guild|null
     */
    public function getGuild()
    {
        if (isset($this->data['guild'])) {
            return $this->data['guild'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Items\Guild|null
     */
    public function getItems()
    {
        if (isset($this->data['items'])) {
            return $this->data['items'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Shared\ListData|null
     */
    public function getMounts()
    {
        if (isset($this->data['mounts'])) {
            return $this->data['mounts'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Pets|null
     */
    public function getPets()
    {
        if (isset($this->data['pets'])) {
            return $this->data['pets'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Professions|null
     */
    public function getProfessions()
    {
        if (isset($this->data['professions'])) {
            return $this->data['professions'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Progression|null
     */
    public function getProgression()
    {
        if (isset($this->data['progression'])) {
            return $this->data['progression'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Pvp|null
     */
    public function getPvp()
    {
        if (isset($this->data['pvp'])) {
            return $this->data['pvp'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Shared\ListData|null
     */
    public function getQuests()
    {
        if (isset($this->data['quests'])) {
            return $this->data['quests'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Reputation|null
     */
    public function getReputation()
    {
        if (isset($this->data['reputation'])) {
            return $this->data['reputation'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Stats|null
     */
    public function getStats()
    {
        if (isset($this->data['stats'])) {
            return $this->data['stats'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Talents|null
     */
    public function getTalents()
    {
        if (isset($this->data['talents'])) {
            return $this->data['talents'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Titles|null
     */
    public function getTitles()
    {
        if (isset($this->data['titles'])) {
            return $this->data['titles'];
        }

        return null;
    }
}