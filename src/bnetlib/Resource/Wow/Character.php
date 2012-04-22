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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib\Resource\Wow;

use bnetlib\Locale\Locatable;
use bnetlib\Resource\ConsumeInterface;
use bnetlib\Resource\ResourceInterface;
use bnetlib\Locale\LocaleAwareInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Character implements ResourceInterface, ConsumeInterface, LocaleAwareInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var bnetlib\Locale\Locatable
     */
    protected $locale;

    /**
     * @var \stdClass|null
     */
    protected $headers;

    /**
     * @var array
     */
    protected $fields = array(
        'achievements' => 'bnetlib\Resource\Wow\Shared\Achievements',
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
    public function populate(array $data)
    {
        $ally = array(1, 3, 4, 7, 11, 22); // horde (2, 5, 6, 8, 9, 10)

        $this->data['name']    = $data['name'];
        $this->data['realm']   = $data['realm'];
        $this->data['race']    = $data['race'];
        $this->data['level']   = $data['level'];
        $this->data['class']   = $data['class'];
        $this->data['gender']  = $data['gender'];
        $this->data['lastmod'] = $data['lastModified'];
        $this->data['avp']     = $data['achievementPoints'];
        $this->data['faction'] = (in_array($data['race'], $ally)) ? 0 : 1;
        $this->data['thumb']   = $data['thumbnail'];

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
    public function setLocale(Locatable $locale)
    {
        $this->locale = $locale;

        foreach ($this->data as $key => $value) {
            if (is_object($value) && $value instanceof LocaleAwareInterface) {
                $this->data[$key]->setLocale($locale);
            }
        }
    }

    /**
     * @return string Character name
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return string Realm name
     */
    public function getRealm()
    {
        return $this->data['realm'];
    }

    /**
     * @return string Realm slug
     */
    public function getRealmSlug()
    {
        return $this->data['slug'];
    }

    /**
     * @return DateTime Last modification
     */
    public function getLastModified()
    {
        return $this->data['lastmod'];
    }

    /**
     * @return string Full Thumbnail URI
     */
    public function getThumbnail()
    {
        return $this->data['thumb'];
    }

    /**
     * @return int Character level
     */
    public function getLevel()
    {
        return $this->data['level'];
    }

    /**
     * @return int Character class
     */
    public function getClass()
    {
        return $this->data['class'];
    }

    /**
     * @return int Character race
     */
    public function getRace()
    {
        return $this->data['race'];
    }

    /**
     * @return int Character gender
     */
    public function getGender()
    {
        return $this->data['gender'];
    }

    /**
     * @return int Character faction. 0 = Alliance, 1 = Horde
     */
    public function getFaction()
    {
        return $this->data['faction'];
    }

    /**
     * @return int Achievement points
     */
    public function getAchievementPoints()
    {
        return $this->data['avp'];
    }

    /**
     * @return string|null
     */
    public function getClassString()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('class.%s', $this->data['class']));
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getRaceString()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('race.%s', $this->data['race']));
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getGenderString()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('gender.%s', $this->data['gender']));
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getFactionString()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('faction.%s', $this->data['faction']));
        }

        return null;
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

    /**
     * @return boolean
     */
    public function isMale()
    {
        return ($this->data['gender'] === 0) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isFemale()
    {
        return ($this->data['gender'] === 1) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isAlliance()
    {
        return ($this->data['faction'] === 0) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isHorde()
    {
        return ($this->data['faction'] === 1) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isHuman()
    {
        return ($this->data['race'] === 1) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isOrc()
    {
        return ($this->data['race'] === 2) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isDwarf()
    {
        return ($this->data['race'] === 3) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isNightElf()
    {
        return ($this->data['race'] === 4) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isUndead()
    {
        return ($this->data['race'] === 5) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isTauren()
    {
        return ($this->data['race'] === 6) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isGnome()
    {
        return ($this->data['race'] === 7) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isTroll()
    {
        return ($this->data['race'] === 8) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isGoblin()
    {
        return ($this->data['race'] === 9) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isBloodElf()
    {
        return ($this->data['race'] === 10) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isDraenei()
    {
        return ($this->data['race'] === 11) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isWorgen()
    {
        return ($this->data['race'] === 22) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isWarrior()
    {
        return ($this->data['class'] === 1) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isPaladin()
    {
        return ($this->data['class'] === 2) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isHunter()
    {
        return ($this->data['class'] === 3) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isRogue()
    {
        return ($this->data['class'] === 4) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isPriest()
    {
        return ($this->data['class'] === 5) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isDeathKnight()
    {
        return ($this->data['class'] === 6) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isShaman()
    {
        return ($this->data['class'] === 7)  ? true : false;
    }

    /**
     * @return boolean
     */
    public function isMage()
    {
        return ($this->data['class'] === 8) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isWarlock()
    {
        return ($this->data['class'] === 9) ? true : false;
    }

    /**
     * @return boolean
     */
    public function isDruid()
    {
        return ($this->data['class'] === 11) ? true : false;
    }

    /**
     * @inheritdoc
     */
    public function consume()
    {
        return array(
            'character' => $this->data['name'],
            'realm'     => $this->data['realm'],
            'thumbnail' => $this->data['thumb']
        );
    }
}