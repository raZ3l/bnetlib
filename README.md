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
* Locale String helper for class names, race names, etc. etc. etc.


Resources
---------

### World of Warcraft

| Resource                    | Method                                |
|-----------------------------|---------------------------------------|
| Achievement                 | `getAchievement()`                    |
| Auction                     | `getAuction()` and `getAuctionData()` |
| Arena Team                  | `getArenaTeam()`                      |
| Arena Ladder                | `getArenaLadder()`                    |
| Rated Battleground Ladder   | Not yet                               |
| Character                   | `getCharacter()` and `getThumbnail()` |
| Guild                       | `getGuild()`                          |
| Realms                      | `getRealms()`                         |
| Quest                       | `getQuest()`                          |
| Item                        | `getItem()`                           |
| Item Set                    | Not yet                               |
| Recipe                      | `getRecipe()`                         |
| Data Battlegroups           | `getBattlegroups()`                   |
| Data Character Races        | `getCharacterRaces()`                 |
| Data Character Classes      | `getCharacterClasses()`               |
| Data Character Achievements | `getCharacterAchievements()`          |
| Data Guild Rewards          | `getGuildRewards()`                   |
| Data Guild Perks            | `getGuildPerks()`                     |
| Data Guild Achievements     | `getGuildAchievements()`              |
| Data Item Classes           | `getItemClasses()`                    |


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
    echo 'Faction: ' . $guild->getFactionLocale();

    $locale->setLocale(Connection::REGION_CN);

    // Faction: 部落
    echo 'Faction: ' . $guild->getFactionLocale();

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

bnetlib is released under the MIT License. For the full copyright and license information see the [`LICENSE`](https://github.com/coss/bnetlib/blob/master/LICENSE) file.