<?php

return array(
    'path' => dirname(__DIR__) . '/src/bnetlib/Data/Fixtures',
    'games' => array(
        'wow' => 'bnetlib\WorldOfWarcraft'
    ),
    'config' => array(
        'defaults' => array(
            'region' => 'eu',
        ),
    ),
    'fixtures' => array(
        /**
         * null   = don't pass any argument
         * array  = passes the array as argument
         * string = consumes the resource specified in the string
         */
        'wow' => array(
            'Achievement' => array(
                'id' => 2144,
            ),
            'ArenaLadder' => array(
                'battlegroup' => 'Cataclysme / Cataclysm',
                'teamsize'    => '2v2',
                'size'        => 5
            ),
            'ArenaTeam' => array(
                'realm'    => 'Stormscale',
                'teamsize' => '2v2',
                'name'     => 'im on one'
            ),
            'Auction' => array(
                'realm' => 'Die ewige Wacht',
            ),
            'AuctionData' => 'Auction',
            'Battlegroups' => null,
            'Character' => array(
                'name'   => 'Coss',
                'realm'  => 'Die ewige Wacht',
                'fields' => array(
                    'guild',
                    'stats',
                    'feed',
                    'talents',
                    'items',
                    'reputation',
                    'titles',
                    'professions',
                    'appearance',
                    'companions',
                    'mounts',
                    'achievements',
                    'progression',
                    'pvp',
                    'quests',
                ),
            ),
            'CharacterAchievements' => null,
            'CharacterClasses' => null,
            'CharacterRaces' => null,
            'Guild' => array(
                'name'   => 'Konterbier',
                'realm'  => 'Die ewige Wacht',
                'fields' => array(
                    'members',
                    'achievements',
                    'news',
                ),
            ),
            'GuildAchievements' => null,
            'GuildPerks' => null,
            'GuildRewards' => null,
            'Item' => array(
                'id' => 38268,
            ),
            'ItemClasses' => null,
            'ItemSet' => array(
               'id' => 1060,
            ),
            'Quest' => array(
                'id' => 7783,
            ),
            'RatedBattlegroundLadder' => array(
                'size' => 5
            ),
            'Realms' => null,
            'Recipe' => array(
                'id' => 33994,
            ),
            'Thumbnail' => 'Character',
            'Icon' => array(
                'size' => 56,
                'icon' => 'spell_holy_symbolofhope'
            )
        ),
        '_extend' => array(
            'wow' => array(
                array(
                    'source' => array(
                        'resource'  => 'Character',
                        'arguments' => array(
                            'name'   => 'Grayze',
                            'realm'  => 'Die ewige Wacht',
                            'fields' => 'pets'
                        ),
                    ),
                    'target' => 'pets'
                ),
            ),
        ),
    ),
);