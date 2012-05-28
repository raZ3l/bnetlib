<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @category  bnetlib
 * @package   ServiceLocator
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\ServiceLocator;

use bnetlib\Locale\LocaleInterface;
use bnetlib\Exception\DomainException;
use bnetlib\Locale\LocaleAwareInterface;
use bnetlib\Resource\ConfigurationInterface;
use bnetlib\Exception\InvalidArgumentException;
use bnetlib\Exception\ServiceNotCreatedException;
use bnetlib\Exception\InvalidServiceNameException;

/**
 * @category  bnetlib
 * @package   ServiceLocator
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ServiceLocator implements ServiceLocatorInterface, LocaleAwareInterface
{
    /**
     * @var bnetlib\Locale\LocaleInterface|null
     */
    protected $locale = null;

    /**
     * @var array
     */
    protected $shared = array();

    /**
     * @var array
     */
    protected $services = array(
        'shared.fallback'                    => 'bnetlib\Resource\Shared\Fallback',
        'shared.file'                        => 'bnetlib\Resource\Shared\File',
        'wow.achievement'                    => 'bnetlib\Resource\Wow\Achievement',
        'wow.achievements.achievement'       => 'bnetlib\Resource\Wow\Achievements\Achievement',
        'wow.achievements.achievements'      => 'bnetlib\Resource\Wow\Achievements\Achievements',
        'wow.achievements.criteria'          => 'bnetlib\Resource\Wow\Achievements\Criteria',
        'wow.achievements.dataachievement'   => 'bnetlib\Resource\Wow\Achievements\DataAchievement',
        'wow.achievements.dataachievements'  => 'bnetlib\Resource\Wow\Achievements\DataAchievements',
        'wow.achievements'                   => 'bnetlib\Resource\Wow\Achievements',
        'wow.arena.character'                => 'bnetlib\Resource\Wow\Arena\Character',
        'wow.arena.statistic'                => 'bnetlib\Resource\Wow\Arena\Statistic',
        'wow.arenaladder'                    => 'bnetlib\Resource\Wow\ArenaLadder',
        'wow.arenateam'                      => 'bnetlib\Resource\Wow\ArenaTeam',
        'wow.auction.auction'                => 'bnetlib\Resource\Wow\Auction\Auction',
        'wow.auction.faction'                => 'bnetlib\Resource\Wow\Auction\Faction',
        'wow.auction'                        => 'bnetlib\Resource\Wow\Auction',
        'wow.auctiondata'                    => 'bnetlib\Resource\Wow\AuctionData',
        'wow.battlegroups.battlegroup'       => 'bnetlib\Resource\Wow\Battlegroups\Battlegroup',
        'wow.battlegroups'                   => 'bnetlib\Resource\Wow\Battlegroups',
        'wow.character.appearance'           => 'bnetlib\Resource\Wow\Character\Appearance',
        'wow.character.arenateam'            => 'bnetlib\Resource\Wow\Character\ArenaTeam',
        'wow.character.arenateams'           => 'bnetlib\Resource\Wow\Character\ArenaTeams',
        'wow.character.classdata'            => 'bnetlib\Resource\Wow\Character\ClassData',
        'wow.character.faction'              => 'bnetlib\Resource\Wow\Character\Faction',
        'wow.character.feed'                 => 'bnetlib\Resource\Wow\Character\Feed',
        'wow.character.feedentry'            => 'bnetlib\Resource\Wow\Character\FeedEntry',
        'wow.character.glyph'                => 'bnetlib\Resource\Wow\Character\Glyph',
        'wow.character.glyphs'               => 'bnetlib\Resource\Wow\Character\Glyphs',
        'wow.character.guild'                => 'bnetlib\Resource\Wow\Character\Guild',
        'wow.character.instance'             => 'bnetlib\Resource\Wow\Character\Instance',
        'wow.character.item'                 => 'bnetlib\Resource\Wow\Character\Item',
        'wow.character.items'                => 'bnetlib\Resource\Wow\Character\Items',
        'wow.character.pet'                  => 'bnetlib\Resource\Wow\Character\Pet',
        'wow.character.pets'                 => 'bnetlib\Resource\Wow\Character\Pets',
        'wow.character.profession'           => 'bnetlib\Resource\Wow\Character\Profession',
        'wow.character.professions'          => 'bnetlib\Resource\Wow\Character\Professions',
        'wow.character.progression'          => 'bnetlib\Resource\Wow\Character\Progression',
        'wow.character.pvp'                  => 'bnetlib\Resource\Wow\Character\Pvp',
        'wow.character.race'                 => 'bnetlib\Resource\Wow\Character\Race',
        'wow.character.ratedbattlegrounds'   => 'bnetlib\Resource\Wow\Character\RatedBattlegrounds',
        'wow.character.record'               => 'bnetlib\Resource\Wow\Character\Record',
        'wow.character.reputation'           => 'bnetlib\Resource\Wow\Character\Reputation',
        'wow.character.stats'                => 'bnetlib\Resource\Wow\Character\Stats',
        'wow.character.talents'              => 'bnetlib\Resource\Wow\Character\Talents',
        'wow.character.talentspecialization' => 'bnetlib\Resource\Wow\Character\TalentSpecialization',
        'wow.character.title'                => 'bnetlib\Resource\Wow\Character\Title',
        'wow.character.titles'               => 'bnetlib\Resource\Wow\Character\Titles',
        'wow.character'                      => 'bnetlib\Resource\Wow\Character',
        'wow.characterclasses'               => 'bnetlib\Resource\Wow\CharacterClasses',
        'wow.characterraces'                 => 'bnetlib\Resource\Wow\CharacterRaces',
        'wow.config.achievement'             => 'bnetlib\Resource\Wow\Configuration\Achievement',
        'wow.config.arenaladder'             => 'bnetlib\Resource\Wow\Configuration\ArenaLadder',
        'wow.config.arenateam'               => 'bnetlib\Resource\Wow\Configuration\ArenaTeam',
        'wow.config.auction'                 => 'bnetlib\Resource\Wow\Configuration\Auction',
        'wow.config.auctiondata'             => 'bnetlib\Resource\Wow\Configuration\AuctionData',
        'wow.config.battlegroups'            => 'bnetlib\Resource\Wow\Configuration\Battlegroups',
        'wow.config.character'               => 'bnetlib\Resource\Wow\Configuration\Character',
        'wow.config.characterachievements'   => 'bnetlib\Resource\Wow\Configuration\CharacterAchievements',
        'wow.config.characterclasses'        => 'bnetlib\Resource\Wow\Configuration\CharacterClasses',
        'wow.config.characterraces'          => 'bnetlib\Resource\Wow\Configuration\CharacterRaces',
        'wow.config.guild'                   => 'bnetlib\Resource\Wow\Configuration\Guild',
        'wow.config.guildachievements'       => 'bnetlib\Resource\Wow\Configuration\GuildAchievements',
        'wow.config.guildperks'              => 'bnetlib\Resource\Wow\Configuration\GuildPerks',
        'wow.config.guildrewards'            => 'bnetlib\Resource\Wow\Configuration\GuildRewards',
        'wow.config.item'                    => 'bnetlib\Resource\Wow\Configuration\Item',
        'wow.config.itemclasses'             => 'bnetlib\Resource\Wow\Configuration\ItemClasses',
        'wow.config.itemset'                 => 'bnetlib\Resource\Wow\Configuration\ItemSet',
        'wow.config.quest'                   => 'bnetlib\Resource\Wow\Configuration\Quest',
        'wow.config.ratedbattlegroundladder' => 'bnetlib\Resource\Wow\Configuration\RatedBattlegroundLadder',
        'wow.config.realms'                  => 'bnetlib\Resource\Wow\Configuration\Realms',
        'wow.config.recipe'                  => 'bnetlib\Resource\Wow\Configuration\Recipe',
        'wow.config.thumbnail'               => 'bnetlib\Resource\Wow\Configuration\Thumbnail',
        'wow.guild.member'                   => 'bnetlib\Resource\Wow\Guild\Member',
        'wow.guild.members'                  => 'bnetlib\Resource\Wow\Guild\Members',
        'wow.guild.news'                     => 'bnetlib\Resource\Wow\Guild\News',
        'wow.guild.newsentry'                => 'bnetlib\Resource\Wow\Guild\NewsEntry',
        'wow.guild.perk'                     => 'bnetlib\Resource\Wow\Guild\Perk',
        'wow.guild.reward'                   => 'bnetlib\Resource\Wow\Guild\Reward',
        'wow.guild.spell'                    => 'bnetlib\Resource\Wow\Guild\Spell',
        'wow.guild'                          => 'bnetlib\Resource\Wow\Guild',
        'wow.guildperks'                     => 'bnetlib\Resource\Wow\GuildPerks',
        'wow.guildrewards'                   => 'bnetlib\Resource\Wow\GuildRewards',
        'wow.item.bonusstats'                => 'bnetlib\Resource\Wow\Item\BonusStats',
        'wow.item.classdata'                 => 'bnetlib\Resource\Wow\Item\ClassData',
        'wow.item.reward'                    => 'bnetlib\Resource\Wow\Item\Reward',
        'wow.item.socketinfo'                => 'bnetlib\Resource\Wow\Item\SocketInfo',
        'wow.item.spell'                     => 'bnetlib\Resource\Wow\Item\Spell',
        'wow.item.spells'                    => 'bnetlib\Resource\Wow\Item\Spells',
        'wow.item.stat'                      => 'bnetlib\Resource\Wow\Item\Stat',
        'wow.item.weaponinfo'                => 'bnetlib\Resource\Wow\Item\WeaponInfo',
        'wow.item'                           => 'bnetlib\Resource\Wow\Item',
        'wow.itemclasses'                    => 'bnetlib\Resource\Wow\ItemClasses',
        'wow.itemset.bonus'                  => 'bnetlib\Resource\Wow\ItemSet\Bonus',
        'wow.itemset'                        => 'bnetlib\Resource\Wow\ItemSet',
        'wow.quest'                          => 'bnetlib\Resource\Wow\Quest',
        'wow.ratedbattlegroundladder'        => 'bnetlib\Resource\Wow\RatedBattlegroundLadder',
        'wow.realms.pvparea'                 => 'bnetlib\Resource\Wow\Realms\PvpArea',
        'wow.realms.realm'                   => 'bnetlib\Resource\Wow\Realms\Realm',
        'wow.realms'                         => 'bnetlib\Resource\Wow\Realms',
        'wow.recipe'                         => 'bnetlib\Resource\Wow\Recipe',
        'wow.shared.arenateam'               => 'bnetlib\Resource\Wow\Shared\ArenaTeam',
        'wow.shared.character'               => 'bnetlib\Resource\Wow\Shared\Character',
        'wow.shared.data'                    => 'bnetlib\Resource\Wow\Shared\Data',
        'wow.shared.guildemblem'             => 'bnetlib\Resource\Wow\Shared\GuildEmblem',
        'wow.shared.item'                    => 'bnetlib\Resource\Wow\Shared\Item',
        'wow.shared.listdata'                => 'bnetlib\Resource\Wow\Shared\ListData',
    );

    /**
     * @inheritdoc
     */
    public function has($name)
    {
        return isset($this->services[$name]);
    }

    /**
     * @param  string  $name
     * @param  boolean $shared
     * @throws bnetlib\Exception\InvalidServiceNameException Unable to find service
     * @throws bnetlib\Exception\ServiceNotCreatedException  Unable to create instance of service
     * @throws bnetlib\Exception\DomainException             Config don't implment ConfigurationInterface
     * @return object
     */
    public function get($name, $shared = false)
    {
        if (!isset($this->services[$name])) {
            throw new InvalidServiceNameException(sprintf('There is no service namend %s.', $name));
        }

        if ($shared === true && isset($this->shared[$name])) {
            return $this->shared[$name];
        }

        if (!class_exists($this->services[$name], true)) {
            throw new ServiceNotCreatedException(sprintf(
                'Unable to create an instance of %s (%s).', $name, $this->services[$name]
            ));
        }

        $instance = new $this->services[$name]();

        if (strpos($this->services[$name], '.config.') !== false) {
            if (!$instance instanceof ConfigurationInterface) {
                throw new DomainException(sprintf('%s must implement ConfigurationInterface.', $name));
            }
        }

        if ($instance instanceof ServiceLocatorAwareInterface) {
            $instance->setServiceLocator($this);
        }
        if ($this->locale !== null && $instance instanceof LocaleAwareInterface) {
            $instance->setLocale($this->locale);
        }

        if ($shared === true) {
            $this->shared[$name] = $instance;
        }

        return $instance;
    }

    /**
     * @param  string $name
     * @param  string $class
     * @return self
     */
    public function set($name, $class)
    {
        if (isset($this->shared[$name])) {
            unset($this->shared[$name]);
        }

        $this->services[$name] = $class;

        return $this;
    }

    /**
     * @param  array $services
     * @return self
     */
    public function fomArray(array $services)
    {
        foreach ($services as $name => $class) {
            if (isset($this->shared[$name])) {
                unset($this->shared[$name]);
            }

            $this->services[$name] = $class;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setLocale(LocaleInterface $locale)
    {
        $this->locale = $locale;

        foreach ($this->shared as $key => $value) {
            if ($value instanceof LocaleAwareInterface) {
                $this->shared[$key]->setLocale($locale);
            }
        }

        return $this;
    }
}