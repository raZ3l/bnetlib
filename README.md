bnetlib [![Build Status](https://secure.travis-ci.org/coss/bnetlib.png?branch=master)](http://travis-ci.org/coss/bnetlib)
=======

bnetlib is an object-oriented interface for the Battle.net REST API. It tries to keep a direct mapping to the actual resource names and response values.


Requirements
------------

bnetlib requires PHP 5.3.3+ and depends on [Zend\Http][1]


Resources
---------

* Achievement `getAchievement()`
* Auction `getAuction()` and `getAuctionData()`
* Arena Team `getArenaTeam()`
* Arena Ladder `getArenaLadder()`
* Character `getCharacter()` and `getThumbnail()`
* Guild `getGuild()`
* Realms `getRealms()`
* Item `getItem()`
* Recipe `getRecipe()`
* Data Battlegroups `getBattlegroups()`
* Data Character Races `getCharacterRaces()`
* Data Character Classes `getCharacterClasses()`
* Data Character Achievements `getCharacterAchievements()`
* Data Guild Rewards `getGuildRewards()`
* Data Guild Perks `getGuildPerks()`
* Data Guild Achievements `getGuildAchievements()`
* Data Item Classes `getItemClasses()`

* ItemSet (not yet)
* PvP Area Status Fields (not yet)
* Rated Battleground Ladder  (not yet)


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


License
-------

See the LICENSE file.

[1]: https://github.com/zendframework/zf2/