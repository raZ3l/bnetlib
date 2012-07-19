<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
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
use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\Exception\InvalidArgumentException;
use bnetlib\Exception\ServiceNotCreatedException;
use bnetlib\Exception\InvalidServiceNameException;
use bnetlib\Resource\Config\ConfigurationInterface;

/**
 * @category  bnetlib
 * @package   ServiceLocator
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class ServiceLocator implements ServiceLocatorInterface, LocaleAwareInterface
{
    /**
     * @var LocaleInterface|null
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
        'd3.config.career'                          => 'bnetlib\Resource\Config\D3\Career',
        'd3.config.hero'                            => 'bnetlib\Resource\Config\D3\Hero',
        'd3.entity.career'                          => 'bnetlib\Resource\Entity\D3\Career',
        'd3.entity.hero'                            => 'bnetlib\Resource\Entity\D3\Hero',
        'd3.entity.shared.hero'                     => 'bnetlib\Resource\Entity\D3\Shared\Hero',
        'shared.entity.data'                        => 'bnetlib\Resource\Entity\Shared\Data',
        'shared.entity.fallback'                    => 'bnetlib\Resource\Entity\Shared\Fallback',
        'shared.entity.image'                       => 'bnetlib\Resource\Entity\Shared\Image',
        'shared.entity.listdata'                    => 'bnetlib\Resource\Entity\Shared\ListData',
        'wow.config.achievement'                    => 'bnetlib\Resource\Config\Wow\Achievement',
        'wow.config.arenaladder'                    => 'bnetlib\Resource\Config\Wow\ArenaLadder',
        'wow.config.arenateam'                      => 'bnetlib\Resource\Config\Wow\ArenaTeam',
        'wow.config.auction'                        => 'bnetlib\Resource\Config\Wow\Auction',
        'wow.config.auctiondata'                    => 'bnetlib\Resource\Config\Wow\AuctionData',
        'wow.config.battlegroups'                   => 'bnetlib\Resource\Config\Wow\Battlegroups',
        'wow.config.character'                      => 'bnetlib\Resource\Config\Wow\Character',
        'wow.config.characterachievements'          => 'bnetlib\Resource\Config\Wow\CharacterAchievements',
        'wow.config.characterclasses'               => 'bnetlib\Resource\Config\Wow\CharacterClasses',
        'wow.config.characterraces'                 => 'bnetlib\Resource\Config\Wow\CharacterRaces',
        'wow.config.guild'                          => 'bnetlib\Resource\Config\Wow\Guild',
        'wow.config.guildachievements'              => 'bnetlib\Resource\Config\Wow\GuildAchievements',
        'wow.config.guildperks'                     => 'bnetlib\Resource\Config\Wow\GuildPerks',
        'wow.config.guildrewards'                   => 'bnetlib\Resource\Config\Wow\GuildRewards',
        'wow.config.icon'                           => 'bnetlib\Resource\Config\Wow\Icon',
        'wow.config.item'                           => 'bnetlib\Resource\Config\Wow\Item',
        'wow.config.itemclasses'                    => 'bnetlib\Resource\Config\Wow\ItemClasses',
        'wow.config.itemset'                        => 'bnetlib\Resource\Config\Wow\ItemSet',
        'wow.config.quest'                          => 'bnetlib\Resource\Config\Wow\Quest',
        'wow.config.ratedbattlegroundladder'        => 'bnetlib\Resource\Config\Wow\RatedBattlegroundLadder',
        'wow.config.realms'                         => 'bnetlib\Resource\Config\Wow\Realms',
        'wow.config.recipe'                         => 'bnetlib\Resource\Config\Wow\Recipe',
        'wow.config.thumbnail'                      => 'bnetlib\Resource\Config\Wow\Thumbnail',
        'wow.entity.achievement'                    => 'bnetlib\Resource\Entity\Wow\Achievement',
        'wow.entity.achievements'                   => 'bnetlib\Resource\Entity\Wow\Achievements',
        'wow.entity.achievements.achievement'       => 'bnetlib\Resource\Entity\Wow\Achievements\Achievement',
        'wow.entity.achievements.achievements'      => 'bnetlib\Resource\Entity\Wow\Achievements\Achievements',
        'wow.entity.achievements.criteria'          => 'bnetlib\Resource\Entity\Wow\Achievements\Criteria',
        'wow.entity.achievements.dataachievement'   => 'bnetlib\Resource\Entity\Wow\Achievements\DataAchievement',
        'wow.entity.achievements.dataachievements'  => 'bnetlib\Resource\Entity\Wow\Achievements\DataAchievements',
        'wow.entity.arena.character'                => 'bnetlib\Resource\Entity\Wow\Arena\Character',
        'wow.entity.arena.statistic'                => 'bnetlib\Resource\Entity\Wow\Arena\Statistic',
        'wow.entity.arenaladder'                    => 'bnetlib\Resource\Entity\Wow\ArenaLadder',
        'wow.entity.arenateam'                      => 'bnetlib\Resource\Entity\Wow\ArenaTeam',
        'wow.entity.auction'                        => 'bnetlib\Resource\Entity\Wow\Auction',
        'wow.entity.auction.auction'                => 'bnetlib\Resource\Entity\Wow\Auction\Auction',
        'wow.entity.auction.faction'                => 'bnetlib\Resource\Entity\Wow\Auction\Faction',
        'wow.entity.auctiondata'                    => 'bnetlib\Resource\Entity\Wow\AuctionData',
        'wow.entity.battlegroups'                   => 'bnetlib\Resource\Entity\Wow\Battlegroups',
        'wow.entity.battlegroups.battlegroup'       => 'bnetlib\Resource\Entity\Wow\Battlegroups\Battlegroup',
        'wow.entity.character'                      => 'bnetlib\Resource\Entity\Wow\Character',
        'wow.entity.character.appearance'           => 'bnetlib\Resource\Entity\Wow\Character\Appearance',
        'wow.entity.character.arenateam'            => 'bnetlib\Resource\Entity\Wow\Character\ArenaTeam',
        'wow.entity.character.arenateams'           => 'bnetlib\Resource\Entity\Wow\Character\ArenaTeams',
        'wow.entity.character.classdata'            => 'bnetlib\Resource\Entity\Wow\Character\ClassData',
        'wow.entity.character.faction'              => 'bnetlib\Resource\Entity\Wow\Character\Faction',
        'wow.entity.character.feed'                 => 'bnetlib\Resource\Entity\Wow\Character\Feed',
        'wow.entity.character.feedentry'            => 'bnetlib\Resource\Entity\Wow\Character\FeedEntry',
        'wow.entity.character.glyph'                => 'bnetlib\Resource\Entity\Wow\Character\Glyph',
        'wow.entity.character.glyphs'               => 'bnetlib\Resource\Entity\Wow\Character\Glyphs',
        'wow.entity.character.guild'                => 'bnetlib\Resource\Entity\Wow\Character\Guild',
        'wow.entity.character.instance'             => 'bnetlib\Resource\Entity\Wow\Character\Instance',
        'wow.entity.character.item'                 => 'bnetlib\Resource\Entity\Wow\Character\Item',
        'wow.entity.character.items'                => 'bnetlib\Resource\Entity\Wow\Character\Items',
        'wow.entity.character.pet'                  => 'bnetlib\Resource\Entity\Wow\Character\Pet',
        'wow.entity.character.pets'                 => 'bnetlib\Resource\Entity\Wow\Character\Pets',
        'wow.entity.character.profession'           => 'bnetlib\Resource\Entity\Wow\Character\Profession',
        'wow.entity.character.professions'          => 'bnetlib\Resource\Entity\Wow\Character\Professions',
        'wow.entity.character.progression'          => 'bnetlib\Resource\Entity\Wow\Character\Progression',
        'wow.entity.character.pvp'                  => 'bnetlib\Resource\Entity\Wow\Character\Pvp',
        'wow.entity.character.race'                 => 'bnetlib\Resource\Entity\Wow\Character\Race',
        'wow.entity.character.ratedbattlegrounds'   => 'bnetlib\Resource\Entity\Wow\Character\RatedBattlegrounds',
        'wow.entity.character.record'               => 'bnetlib\Resource\Entity\Wow\Character\Record',
        'wow.entity.character.reputation'           => 'bnetlib\Resource\Entity\Wow\Character\Reputation',
        'wow.entity.character.stats'                => 'bnetlib\Resource\Entity\Wow\Character\Stats',
        'wow.entity.character.talents'              => 'bnetlib\Resource\Entity\Wow\Character\Talents',
        'wow.entity.character.talentspecialization' => 'bnetlib\Resource\Entity\Wow\Character\TalentSpecialization',
        'wow.entity.character.title'                => 'bnetlib\Resource\Entity\Wow\Character\Title',
        'wow.entity.character.titles'               => 'bnetlib\Resource\Entity\Wow\Character\Titles',
        'wow.entity.characterclasses'               => 'bnetlib\Resource\Entity\Wow\CharacterClasses',
        'wow.entity.characterraces'                 => 'bnetlib\Resource\Entity\Wow\CharacterRaces',
        'wow.entity.guild'                          => 'bnetlib\Resource\Entity\Wow\Guild',
        'wow.entity.guild.member'                   => 'bnetlib\Resource\Entity\Wow\Guild\Member',
        'wow.entity.guild.members'                  => 'bnetlib\Resource\Entity\Wow\Guild\Members',
        'wow.entity.guild.news'                     => 'bnetlib\Resource\Entity\Wow\Guild\News',
        'wow.entity.guild.newsentry'                => 'bnetlib\Resource\Entity\Wow\Guild\NewsEntry',
        'wow.entity.guild.perk'                     => 'bnetlib\Resource\Entity\Wow\Guild\Perk',
        'wow.entity.guild.reward'                   => 'bnetlib\Resource\Entity\Wow\Guild\Reward',
        'wow.entity.guild.spell'                    => 'bnetlib\Resource\Entity\Wow\Guild\Spell',
        'wow.entity.guildperks'                     => 'bnetlib\Resource\Entity\Wow\GuildPerks',
        'wow.entity.guildrewards'                   => 'bnetlib\Resource\Entity\Wow\GuildRewards',
        'wow.entity.item'                           => 'bnetlib\Resource\Entity\Wow\Item',
        'wow.entity.item.bonusstats'                => 'bnetlib\Resource\Entity\Wow\Item\BonusStats',
        'wow.entity.item.classdata'                 => 'bnetlib\Resource\Entity\Wow\Item\ClassData',
        'wow.entity.item.reward'                    => 'bnetlib\Resource\Entity\Wow\Item\Reward',
        'wow.entity.item.socketinfo'                => 'bnetlib\Resource\Entity\Wow\Item\SocketInfo',
        'wow.entity.item.spell'                     => 'bnetlib\Resource\Entity\Wow\Item\Spell',
        'wow.entity.item.spells'                    => 'bnetlib\Resource\Entity\Wow\Item\Spells',
        'wow.entity.item.stat'                      => 'bnetlib\Resource\Entity\Wow\Item\Stat',
        'wow.entity.item.weaponinfo'                => 'bnetlib\Resource\Entity\Wow\Item\WeaponInfo',
        'wow.entity.itemclasses'                    => 'bnetlib\Resource\Entity\Wow\ItemClasses',
        'wow.entity.itemset'                        => 'bnetlib\Resource\Entity\Wow\ItemSet',
        'wow.entity.itemset.bonus'                  => 'bnetlib\Resource\Entity\Wow\ItemSet\Bonus',
        'wow.entity.quest'                          => 'bnetlib\Resource\Entity\Wow\Quest',
        'wow.entity.ratedbattlegroundladder'        => 'bnetlib\Resource\Entity\Wow\RatedBattlegroundLadder',
        'wow.entity.realms'                         => 'bnetlib\Resource\Entity\Wow\Realms',
        'wow.entity.realms.pvparea'                 => 'bnetlib\Resource\Entity\Wow\Realms\PvpArea',
        'wow.entity.realms.realm'                   => 'bnetlib\Resource\Entity\Wow\Realms\Realm',
        'wow.entity.recipe'                         => 'bnetlib\Resource\Entity\Wow\Recipe',
        'wow.entity.shared.arenateam'               => 'bnetlib\Resource\Entity\Wow\Shared\ArenaTeam',
        'wow.entity.shared.character'               => 'bnetlib\Resource\Entity\Wow\Shared\Character',
        'wow.entity.shared.guildemblem'             => 'bnetlib\Resource\Entity\Wow\Shared\GuildEmblem',
        'wow.entity.shared.item'                    => 'bnetlib\Resource\Entity\Wow\Shared\Item',
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
     * @throws bnetlib\Exception\DomainException             Entity don't implment EntityInterface
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

        if (strpos($name, '.config.') !== false) {
            if (!$instance instanceof ConfigurationInterface) {
                throw new DomainException(sprintf('%s must implement ConfigurationInterface.', $name));
            }
        }

        if (strpos($name, '.entity.') !== false) {
            if (!$instance instanceof EntityInterface) {
                throw new DomainException(sprintf('%s must implement EntityInterface.', $name));
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
     * @param  string $name  Service name
     * @param  string $class FQCN
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
     * @param  array $services Service name as key and FQCN as value.
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
     * Inject a Locale object and tries to inject the object in shared instances.
     *
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