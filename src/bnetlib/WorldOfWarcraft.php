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
 * @package    Game
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.github.com/bnetlib/license.html    MIT License
 */

namespace bnetlib;

use bnetlib\Connection\ConnectionInterface;
use bnetlib\Resource\Entity\ConsumeInterface;

/**
 * @category   bnetlib
 * @package    Game
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 *
 * @method     mixed getArenaLadder(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getArenaTeam(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getAuction(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getAuctionData(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getBattlegroups(array $args = null)
 * @method     mixed getCharacter(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getCharacterAchievements(array $args = null)
 * @method     mixed getCharacterClasses(array $args = null)
 * @method     mixed getCharacterRaces(array $args = null)
 * @method     mixed getGuild(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getGuildAchievements(array $args = null)
 * @method     mixed getGuildPerks(array $args = null)
 * @method     mixed getGuildRewards(array $args = null)
 * @method     mixed getItem(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getItemSet(array $args = null)
 * @method     mixed getItemClasses(array $args = null)
 * @method     mixed getQuest(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getRatedBattlegroundLadder(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getRealm(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getRecipe(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
 * @method     mixed getThumbnail(array|ConsumeInterface $args, array|ConsumeInterface $extra = null)
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
        'Icon'                    => 'shared.entity.image',
        'Item'                    => 'wow.entity.item',
        'ItemClasses'             => 'wow.entity.itemclasses',
        'ItemSet'                 => 'wow.entity.itemset',
        'Quest'                   => 'wow.entity.quest',
        'RatedBattlegroundLadder' => 'wow.entity.ratedbattlegroundladder',
        'Realms'                  => 'wow.entity.realms',
        'Recipe'                  => 'wow.entity.recipe',
        'Thumbnail'               => 'shared.entity.image',
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
