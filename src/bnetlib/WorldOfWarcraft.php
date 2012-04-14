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
 *
 * @method     mixed getAuction(array $args [, Resource\Utilizable $instance])
 * @method     mixed getAuctionData(array $args [, Resource\Utilizable $instance])
 * @method     mixed getCharacter(array $args [, Resource\Utilizable $instance])
 * @method     mixed getCharacterClasses([array $args])
 * @method     mixed getCharacterRaces([array $args])
 * @method     mixed getGuild(array $args [, Resource\Utilizable $instance])
 * @method     mixed getGuildPerks([array $args])
 * @method     mixed getGuildRewards([array $args])
 * @method     mixed getItem(array $args [, Resource\Utilizable $instance])
 * @method     mixed getItemClasses([array $args])
 * @method     mixed getPvp(array $args [, Resource\Utilizable $instance])
 * @method     mixed getRealm([array $args])
 */
class WorldOfWarcraft extends AbstractGame
{
    /**
     * @inheritdoc
     */
    protected $resources = array(
        'ArenaLadder' => array(
            'class'  => 'bnetlib\Resource\Wow\ArenaLadder',
            'config' => 'bnetlib\Resource\Wow\Configuration\ArenaLadder'
        ),
        'ArenaTeam' => array(
            'class'  => 'bnetlib\Resource\Wow\ArenaTeam',
            'config' => 'bnetlib\Resource\Wow\Configuration\ArenaTeam'
        ),
        'Auction' => array(
            'class'  => 'bnetlib\Resource\Wow\Auction',
            'config' => 'bnetlib\Resource\Wow\Configuration\Auction'
        ),
        'AuctionData' => array(
            'class'  => 'bnetlib\Resource\Wow\AuctionData',
            'config' => 'bnetlib\Resource\Wow\Configuration\AuctionData'
        ),
        'Battlegroups' => array(
            'class'  => 'bnetlib\Resource\Wow\Battlegroups',
            'config' => 'bnetlib\bnetlib\Resource\Wow\Configuration\Battlegroups'
        ),
        'Character' => array(
            'class'  => 'bnetlib\Resource\Wow\Character',
            'config' => 'bnetlib\bnetlib\Resource\Wow\Configuration\Character'
        ),
        'CharacterAchievements' => array(
            'class'  => 'bnetlib\Resource\Wow\CharacterAchievements',
            'config' => 'bnetlib\Resource\Wow\Configuration\CharacterAchievements'
        ),
        'CharacterClasses' => array(
            'class'  => 'bnetlib\Resource\Wow\CharacterClasses',
            'config' => 'bnetlib\Resource\Wow\Configuration\CharacterClasses'
        ),
        'CharacterRaces' => array(
            'class'  => 'bnetlib\Resource\Wow\CharacterRaces',
            'config' => 'bnetlib\Resource\Wow\Configuration\CharacterRaces'
        ),
        'Guild' => array(
            'class'  => 'bnetlib\Resource\Wow\Guild',
            'config' => 'bnetlib\Resource\Wow\Configuration\Guild'
        ),
        'GuildAchievements' => array(
            'class'  => 'bnetlib\Resource\Wow\GuildAchievements',
            'config' => 'bnetlib\Resource\Wow\Configuration\GuildAchievements'
        ),
        'GuildPerks' => array(
            'class'  => 'bnetlib\Resource\Wow\GuildPerks',
            'config' => 'bnetlib\Resource\Wow\Configuration\GuildPerks'
        ),
        'GuildRewards' => array(
            'class'  => 'bnetlib\Resource\Wow\GuildRewards',
            'config' => 'bnetlib\Resource\Wow\Configuration\GuildRewards'
        ),
        'Item' => array(
            'class'  => 'bnetlib\Resource\Wow\Item',
            'config' => 'bnetlib\Resource\Wow\Configuration\Item'
        ),
        'ItemClasses' => array(
            'class'  => 'bnetlib\Resource\Wow\ItemClasses',
            'config' => 'bnetlib\Resource\Wow\Configuration\ItemClasses'
        ),
        'Quest' => array(
            'class'  => 'bnetlib\Resource\Wow\Quest',
            'config' => 'bnetlib\Resource\Wow\Configuration\Quest'
        ),
        'Realm' => array(
            'class'  => 'bnetlib\Resource\Wow\Realm',
            'config' => 'bnetlib\Resource\Wow\Configuration\Realm'
        ),
        'Recipe' => array(
            'class'  => 'bnetlib\Resource\Wow\Recipe',
            'config' => 'bnetlib\Resource\Wow\Configuration\Recipe'
        ),
        'Thumbnail' => array(
            'class'  => 'bnetlib\Resource\Wow\Thumbnail',
            'config' => 'bnetlib\Resource\Wow\Configuration\Thumbnail'
        )
    );

    /**
     * @inheritdoc
     */
    protected $locale = array(
        ConnectionInterface::REGION_US => array(
            ConnectionInterface::LOCALE_US,
            ConnectionInterface::LOCALE_MX
        ),
        ConnectionInterface::REGION_EU => array(
            ConnectionInterface::LOCALE_GB,
            ConnectionInterface::LOCALE_ES,
            ConnectionInterface::LOCALE_FR,
            ConnectionInterface::LOCALE_RU,
            ConnectionInterface::LOCALE_DE
        ),
        ConnectionInterface::REGION_KR => array(ConnectionInterface::LOCALE_KR),
        ConnectionInterface::REGION_TW => array(ConnectionInterface::LOCALE_TW),
        ConnectionInterface::REGION_CN => array(ConnectionInterface::LOCALE_CN)
    );
}
