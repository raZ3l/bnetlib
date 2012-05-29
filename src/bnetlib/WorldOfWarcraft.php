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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE    MIT License
 */

namespace bnetlib;

use bnetlib\Connection\ConnectionInterface;

/**
 * @category   bnetlib
 * @package    Game
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 *
 * @method     mixed getArenaLadder(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getArenaTeam(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getAuction(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getAuctionData(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getBattlegroups([array $args])
 * @method     mixed getCharacter(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getCharacterAchievements([array $args])
 * @method     mixed getCharacterClasses([array $args])
 * @method     mixed getCharacterRaces([array $args])
 * @method     mixed getGuild(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getGuildAchievements([array $args])
 * @method     mixed getGuildPerks([array $args])
 * @method     mixed getGuildRewards([array $args])
 * @method     mixed getItem(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getItemSet(array $args)
 * @method     mixed getItemClasses([array $args])
 * @method     mixed getQuest(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getRatedBattlegroundLadder(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getRealm([array $args, [Resource\ConsumeInterface $instance]])
 * @method     mixed getRecipe(array $args [, Resource\ConsumeInterface $instance])
 * @method     mixed getThumbnail(array $args [, Resource\ConsumeInterface $instance])
 */
class WorldOfWarcraft extends AbstractGame
{
    /**
     * @const string
     */
    const SHORT_NAME = 'wow';

    /**
     * @inheritdoc
     */
    protected $resources = array(
        'Achievement'             => 'wow.entity.achievement',
        'ArenaLadder'             => 'wow.entity.arenaladder',
        'ArenaTeam'               => 'wow.entity.arenateam',
        'Auction'                 => 'wow.entity.auction',
        'AuctionData'             => 'wow.entity.auctiondata',
        'Battlegroups'            => 'wow.entity.battlegroups',
        'Character'               => 'wow.entity.character',
        'CharacterAchievements'   => 'wow.entity.achievements',
        'CharacterClasses'        => 'wow.entity.characterclasses',
        'CharacterRaces'          => 'wow.entity.characterraces',
        'Guild'                   => 'wow.entity.guild',
        'GuildAchievements'       => 'wow.entity.achievements',
        'GuildPerks'              => 'wow.entity.guildperks',
        'GuildRewards'            => 'wow.entity.guildrewards',
        'Item'                    => 'wow.entity.item',
        'ItemClasses'             => 'wow.entity.itemclasses',
        'ItemSet'                 => 'wow.entity.itemset',
        'Quest'                   => 'wow.entity.quest',
        'RatedBattlegroundLadder' => 'wow.entity.ratedbattlegroundladder',
        'Realms'                  => 'wow.entity.realms',
        'Recipe'                  => 'wow.entity.recipe',
        'Thumbnail'               => 'shared.entity.file',
    );

    /**
     * @inheritdoc
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
            ConnectionInterface::LOCALE_PT

        ),
        ConnectionInterface::REGION_KR => array(ConnectionInterface::LOCALE_KR),
        ConnectionInterface::REGION_TW => array(ConnectionInterface::LOCALE_TW),
        ConnectionInterface::REGION_CN => array(ConnectionInterface::LOCALE_CN)
    );
}
