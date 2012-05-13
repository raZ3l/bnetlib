bnetlib [![Build Status](https://secure.travis-ci.org/coss/bnetlib.png?branch=master)](http://travis-ci.org/coss/bnetlib)
=======

bnetlib is an object-oriented interface for the Battle.net REST API. It tries to keep a direct mapping to the actual resource names and response values.


Requirements
------------

bnetlib requires PHP 5.3.3+ and depends on [`Zend\Http`](https://github.com/zendframework/zf2/).


Supports
--------

* If-Modified-Since Header
* Application authentication
* Returns simple array or full blown object
* Locale string helper for class names, race names, etc. etc. etc.


Resources
---------

### World of Warcraft

| Resource                    | Method                                |
|-----------------------------|---------------------------------------|
| Achievement                 | `getAchievement()`                    |
| Arena Ladder                | `getArenaLadder()`                    |
| Arena Team                  | `getArenaTeam()`                      |
| Auction                     | `getAuction()` and `getAuctionData()` |
| Battlegroups                | `getBattlegroups()`                   |
| Character                   | `getCharacter()` and `getThumbnail()` |
| Character Achievements      | `getCharacterAchievements()`          |
| Character Classes           | `getCharacterClasses()`               |
| Character Races             | `getCharacterRaces()`                 |
| Guild                       | `getGuild()`                          |
| Guild Achievements          | `getGuildAchievements()`              |
| Guild Perks                 | `getGuildPerks()`                     |
| Guild Rewards               | `getGuildRewards()`                   |
| Item                        | `getItem()`                           |
| Item Classes                | `getItemClasses()`                    |
| Item Set                    | `getItemSet()`                        |
| Quest                       | `getQuest()`                          |
| Rated Battleground Ladder   | `getRatedBattlegroundLadder()`        |
| Recipe                      | `getRecipe()`                         |
| Realms                      | `getRealms()`                         |


Autoloading
-----------

bnetlib is PSR-0 compliant and provides a [class map](https://github.com/coss/bnetlib/blob/master/src/bnetlib/_classmap.php). You may use any PSR-0 compliant/class map autoloader (like [`Zend\Loader`](https://github.com/zendframework/zf2/)) or use the fallback [`_autoload.php`](https://github.com/coss/bnetlib/blob/master/src/bnetlib/_autoload.php).


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

    // gettype($guild) -> object (bnetlib\Resource\Wow\Guild)
    $guild = $wow->getGuild(array(
        'realm'  => 'Blackrock',
        'name'   => 'Roots of Dragonmaw',
        'region' => Connection::REGION_EU,
        'locale' => Connection::LOCALE_DE,
        'fields' => 'members',
    ));

    $wow->setReturnType(WorldOfWarcraft::RETURN_PLAIN);

    // gettype($realms) -> array
    $realms = $wow->getRealms(array(
        'region' => Connection::REGION_EU
    ));

    $locale = new Locale(WorldOfWarcraft::SHORT_NAME, Connection::LOCALE_ES);
    $guild->setLocale($locale)

    // Faction: Horda
    echo 'Faction: ' . $guild->getFactionLocale();

    $locale->setLocale(Connection::REGION_CN);

    // Faction: 部落
    echo 'Faction: ' . $guild->getFactionLocale();

    foreach ($guild->getMembers() as $i => $member) {
        // gettype($character) -> object (bnetlib\Resource\Wow\Character)
        $character = $member->getCharacter();
        echo 'Name: ' $character->getName();

        if ($character->isMage() && $character->isUndead()) {
            // gettype($character) -> object (bnetlib\Resource\Wow\Character)
            $character = $wow->getCharacter(
                $character,
                array(
                    'return' => WorldOfWarcraft::RETURN_OBJECT,
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

bnetlib is released under the MIT License. For the full copyright and license information see the [`LICENSE`](https://github.com/coss/bnetlib/blob/master/LICENSE) file.