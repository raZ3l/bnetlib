bnetlib
=======

bnetlib is an object-oriented interface for the Battle.net REST API. It tries to keep a direct mapping to the actual resource names and response values.

Resources
---------

* Achievement
   * `getAchievement()` (`bnetlib\Resource\Wow\Achievement`)
* Auction
   * `getAuction()` (`bnetlib\Resource\Wow\Auction`)
   * `getAuctionData()` (`bnetlib\Resource\Wow\AuctionData`)
* Arena Team
   * `getArenaTeam()` (`bnetlib\Resource\Wow\ArenaTeam`)
* Arena Ladder
   * `getArenaLadder()` (`bnetlib\Resource\Wow\ArenaLadder`)
* Character
   * `getCharacter()` (`bnetlib\Resource\Wow\Character`)
   * `getThumbnail()` (`bnetlib\Resource\Shared\File`)
* Guild
   * `getGuild()` (`bnetlib\Resource\Wow\Guild`)
* Realms
   * `getRealms()` (`bnetlib\Resource\Wow\Realms`)
* PvP Area Status Fields (not yet)
* Item
   * `getItem()` (`bnetlib\Resource\Wow\Item`)
* ItemSet (not yet)
* Rated Battleground Ladder  (not yet)
* Recipe
   * `getRecipe()` (`bnetlib\Resource\Wow\Recipe`)
* Data Battlegroups
   * `getBattlegroups()` (`bnetlib\Resource\Wow\Battlegroups`)
* Data Character Races
   * `getCharacterRaces()` (`bnetlib\Resource\Wow\CharacterRaces`)
* Data Character Classes
   * `getCharacterClasses()` (`bnetlib\Resource\Wow\CharacterClasses`)
* Data Character Achievements
   * `getCharacterAchievements()` (`bnetlib\Resource\Wow\CharacterAchievements`)
* Data Guild Rewards
   * `getGuildRewards()` (`bnetlib\Resource\Wow\GuildRewards`)
* Data Guild Perks
   * `getGuildPerks()` (`bnetlib\Resource\Wow\GuildPerks`)
* Data Guild Achievements
   * `getGuildAchievements()` (`bnetlib\Resource\Wow\GuildAchievements`)
* Data Item Classes
   * `getItemClasses()` (`bnetlib\Resource\Wow\ItemClasses`)

Example
-------

    use bnetlib\Connection;
    use bnetlib\Locale\Locale;
    use bnetlib\WorldOfWarcraft;

    $connection = new Connection();
    $connection->setConfig(array(
        'defaults' => array(
            'region' => Connection::REGION_EU,
            'locale' => array(
                Connection::REGION_EU => Connection::LOCALE_DE
            )
        )
    ));

    $wow = new WorldOfWarcraft($connection);

        OR

    $wow = new WorldOfWarcraft();

    $wow->setReturnType(WorldOfWarcraft::RETURN_PLAIN);

    // gettype($realms) -> array
    $realms = $wow->getRealms(array(
        'region' => Connection::REGION_EU
    ));

    // gettype($guild) -> object (bnetlib\Resource\Wow\Guild)
    $guild = $wow->getGuild(array(
        'realm'  => 'Blackrock',
        'name'   => 'Roots of Dragonmaw',
        'region' => Connection::REGION_EU,
        'locale' => Connection::LOCALE_DE,
        'fields' => 'members',
        'return' => WorldOfWarcraft::RETURN_OBJECT
    ));

    $locale = new Locale(WorldOfWarcraft::SHORT_NAME, Connection::LOCALE_ES);
    $guild->setLocale($locale)

    // Faction: Horda
    echo 'Faction: ' . $guild->getFactionString();

    $locale->setLocale(Connection::REGION_CN);

    // Faction: 部落
    echo 'Faction: ' . $guild->getFactionString();

    foreach ($guild->getMembers() as $i => $member) {
        $character = $member->getCharacter();
        echo 'Name: ' $character->getName();

        if ($character->isMage() && $character->isUndead()) {
            $character = $wow->getCharacter(
                $character,
                array(
                    'fields' => array('titles', 'talents', 'professions')
                )
            );

            $titles = $character->getTitles();
            if ($titles->hasSelected()) {
                $selected = $titles->getSelected();

                // Title: %s the Insane
                echo 'Title: ' . $selected->getTile();

                // Title: Thatguy the Insane
                echo 'Title: ' . $selected->getFullName();
            }

            $professions = $character->getProfessions();
            if ($professions->hasPrimaryProfession() && $professions->hasFirstAid()) {
                $firstaid = $professions->getById(129);

                echo $firstaid->has(23787);
            }
        }
    }