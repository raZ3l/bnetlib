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
 * @package    Game
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib;

/**
 * @category   bnetlib
 * @package    Game
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class WorldOfWarcraft
{
    /**
     * @var array
     */
    protected $locale = array(
        ConnectionInterface::REGION_US => array(
            ConnectionInterface::LOCALE_US,
            ConnectionInterface::LOCALE_MX,
            ConnectionInterface::LOCALE_BR
        ),
        ConnectionInterface::REGION_EU => array(
            ConnectionInterface::LOCALE_GB,
            ConnectionInterface::LOCALE_ES,
            ConnectionInterface::LOCALE_FR,
            ConnectionInterface::LOCALE_RU,
            ConnectionInterface::LOCALE_DE,
            ConnectionInterface::LOCALE_IT,
            ConnectionInterface::LOCALE_PT
        ),
        ConnectionInterface::REGION_KR => array(ConnectionInterface::LOCALE_KR),
        ConnectionInterface::REGION_TW => array(ConnectionInterface::LOCALE_TW),
        ConnectionInterface::REGION_CN => array(ConnectionInterface::LOCALE_CN)
    );

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection = null)
    {
        $this->connection = ($connection) ?: new Connection();
    }

    /**
     * @param  int|const $region
     * @return array|null
     */
    public function getSupportedLocale($region)
    {
        if (isset($this->locale[$region])) {
            return $this->locale[$region];
        }

        return null;
    }

    public function getArenaTeam()
    {

    }

    public function getAuction()
    {

    }

    public function getCharacter()
    {

    }

    public function getCharacterClasses()
    {

    }

    public function getCharacterRaces()
    {

    }

    public function getGuild()
    {

    }

    public function getGuildPerks()
    {

    }

    public function getGuildRewards()
    {

    }

    public function getItem()
    {

    }

    public function getItemClasses()
    {

    }

    public function getRealm()
    {

    }
}
