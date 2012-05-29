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

use bnetlib\ServiceLocator\ServiceLocatorInterface;
use bnetlib\Resource\Entity\Wow\Shared\ArenaTeam as BaseArenaTeam;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ArenaTeam extends BaseArenaTeam implements \Iterator
{
    /**
     * @var int
     */
    protected $position = 0;

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
                    $this->data['created'] = strtotime($value . ' UTC');
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
     * @return string
     */
    public function getRealm()
    {
        return $this->data['realm'];
    }

    /**
     * @return int
     */
    public function getRanking()
    {
        return $this->data['ranking'];
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->data['created'];
    }

    /**
     * @return int
     */
    public function gePlayed()
    {
        return $this->data['gamesPlayed'];
    }

    /**
     * @return int
     */
    public function getWon()
    {
        return $this->data['gamesWon'];
    }

    /**
     * @return int
     */
    public function getLost()
    {
        return $this->data['gamesLost'];
    }

    /**
     * @return int
     */
    public function getSessionPlayed()
    {
        return $this->data['sessionGamesPlayed'];
    }

    /**
     * @return int
     */
    public function getSessionWon()
    {
        return $this->data['sessionGamesWon'];
    }

    /**
     * @return int
     */
    public function getSessionLost()
    {
        return $this->data['sessionGamesLost'];
    }

    /**
     * @return int
     */
    public function getFaction()
    {
        return $this->data['side'];
    }

    /**
     * @return int
     */
    public function getCurrentWeekRanking()
    {
        return $this->data['currentWeekRanking'];
    }

    /**
     * @return int
     */
    public function getLastSessionRanking()
    {
        return $this->data['lastSessionRanking'];
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
     * @return bnetlib\Resource\Entity\Wow\ArenaLadder\Character
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * @see    \Iterator
     * @return string
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
        return isset($this->data[$this->position]);
    }
}