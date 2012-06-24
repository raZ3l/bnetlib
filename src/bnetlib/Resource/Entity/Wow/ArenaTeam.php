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

use bnetlib\Locale\LocaleInterface;
use bnetlib\Locale\LocaleAwareInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;
use bnetlib\Resource\Entity\Wow\Shared\ArenaTeam as BaseArenaTeam;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ArenaTeam extends BaseArenaTeam implements LocaleAwareInterface, \Iterator
{
    /**
     * @var integer
     */
    protected $position = 0;

    /**
     * @var LocaleInterface
     */
    protected $locale;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'members':
                    foreach ($value as $i => $member) {
                        $stats = array();
                        foreach ($member as $stat => $sval) {
                            if ($stat === 'character') {
                                continue;
                            }
                            $stats[$stat] = $sval;
                        }
                        $member['character']['statistic'] = $stats;

                        $this->data['members'][$i] = $this->serviceLocator->get('wow.entity.arena.character');
                        if (isset($this->headers)) {
                            $this->data['members'][$i]->setResponseHeaders($this->headers);
                        }
                        $this->data['members'][$i]->populate($member['character']);
                    }
                    break;
                case 'teamsize':
                    $map = array(2 => '2v2', 3 => '3v3', 5 => '5v5');
                    $this->data['size'] = $map[$value];
                    break;
                case 'created':
                    $this->data['created'] = new \DateTime($value, new \DateTimeZone('UTC'));
                    break;
                case 'side':
                    $ally = array(1, 3, 4, 7, 11, 22); // horde (2, 5, 6, 8, 9, 10)
                    $this->data['side'] = (in_array($data['members'][0]['character']['race'], $ally)) ? 0 : 1;
                    break;
                default:
                    $this->data[$key] = $value;
                    break;
            }
        }
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
     * @return array
     */
    public function toArray()
    {
        return $this->data;
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
    public function getRanking()
    {
        return $this->data['ranking'];
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->data['created'];
    }

    /**
     * @return integer
     */
    public function gePlayed()
    {
        return $this->data['gamesPlayed'];
    }

    /**
     * @return integer
     */
    public function getWon()
    {
        return $this->data['gamesWon'];
    }

    /**
     * @return integer
     */
    public function getLost()
    {
        return $this->data['gamesLost'];
    }

    /**
     * @return integer
     */
    public function getSessionPlayed()
    {
        return $this->data['sessionGamesPlayed'];
    }

    /**
     * @return integer
     */
    public function getSessionWon()
    {
        return $this->data['sessionGamesWon'];
    }

    /**
     * @return integer
     */
    public function getSessionLost()
    {
        return $this->data['sessionGamesLost'];
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
    public function getCurrentWeekRanking()
    {
        return $this->data['currentWeekRanking'];
    }

    /**
     * @return integer
     */
    public function getLastSessionRanking()
    {
        return $this->data['lastSessionRanking'];
    }

    /**
     * @return array
     */
    public function getMembers()
    {
        return $this->data['members'];
    }

    /**
     * @see \Iterator
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @see    \Iterator
     * @return Arena\Character
     */
    public function current()
    {
        return $this->data['members'][$this->position];
    }

    /**
     * @see    \Iterator
     * @return integer
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @see \Iterator
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @see    \Iterator
     * @return boolean
     */
    public function valid()
    {
        return isset($this->data['members'][$this->position]);
    }
}