bnetlib [![Build Status](https://secure.travis-ci.org/coss/bnetlib.png?branch=master)](http://travis-ci.org/coss/bnetlib)
=======

bnetlib is an object-oriented interface for the Battle.net REST-ish API. It tries to keep a direct mapping to the actual resource names and response values. See the [Documentation](http://coss.github.com/bnetlib) for more details.

**Diablo preview:** Blizzard just released a preview for the Diablo III API ([Forum](http://us.battle.net/wow/en/forum/topic/5271598804?page=1#1), [GitHub](https://github.com/Blizzard/d3-api-docs)). You can find a working implementation (in combination with the stub connection) for the latest preview under the [`diablo-preview`](https://github.com/coss/bnetlib/tree/diablo-preview) branch. Estimated API release: End of June or early of July.


Requirements
------------

bnetlib requires PHP 5.3.3+ and depends on (one of) the following HTTP libraries:
* Buzz Library ([`Buzz`](https://github.com/kriswallsmith/Buzz))
* Zend Framework ([`Zend\Http`](https://github.com/zendframework/zf2))
* *Aura Framework ([`Aura.Http`](https://github.com/auraphp/Aura.Http)) – currently broken due to latest master changes.*


Features
--------

* If-Modified-Since Header support.
* Application authentication support.
* Stub connection for testing and development.
* Returns simple array or full blown entity object.
* Converts timestamps to `DateTime` objects (`getDate()`).
* Locale string helper for class names, race names, etc.


Composer
--------

    $ cd path/to/bnetlib
    $ php composer.phar install


> **Note:** If you want to use the Aura or Buzz adapter, you have to add it to the composer.json file. You can do this by running the `require` command.

    $ php composer.phar require Aura/Http:dev-1.0.0-beta2
    $ php composer.phar require kriswallsmith/buzz:0.6


Autoloading
-----------

bnetlib is PSR-0 compliant and provides a [class map](https://github.com/coss/bnetlib/blob/master/autoload_classmap.php). You may use any PSR-0 compliant/class map autoloader you like (e.g. [`Zend\Loader`](https://github.com/zendframework/zf2) or [`Symfony's ClassLoader`](https://github.com/symfony/ClassLoader)) or use the fallback [`autoload_register.php`](https://github.com/coss/bnetlib/blob/master/autoload_register.php).


Resources
---------

### World of Warcraft

| Resource                  | Method                         |
|---------------------------|--------------------------------|
| Achievement               | `getAchievement()`             |
| Arena Ladder              | `getArenaLadder()`             |
| Arena Team                | `getArenaTeam()`               |
| Auction                   | `getAuction()`                 |
| Auction File              | `getAuctionData()`             |
| Battlegroups              | `getBattlegroups()`            |
| Character                 | `getCharacter()`               |
| Character Achievements    | `getCharacterAchievements()`   |
| Character Classes         | `getCharacterClasses()`        |
| Character Races           | `getCharacterRaces()`          |
| Guild                     | `getGuild()`                   |
| Guild Achievements        | `getGuildAchievements()`       |
| Guild Perks               | `getGuildPerks()`              |
| Guild Rewards             | `getGuildRewards()`            |
| Icon Image                | `getIcon()`                    |
| Item                      | `getItem()`                    |
| Item Classes              | `getItemClasses()`             |
| Item Set                  | `getItemSet()`                 |
| Quest                     | `getQuest()`                   |
| Rated Battleground Ladder | `getRatedBattlegroundLadder()` |
| Recipe                    | `getRecipe()`                  |
| Realms                    | `getRealms()`                  |
| Thumbnail Image           | `getThumbnail()`               |


Example
-------

    use bnetlib\Locale\Locale;
    use bnetlib\WorldOfWarcraft;
    use bnetlib\Connection\ZendFramework;

    $locale = new Locale(ZendFramework::LOCALE_ES);

    $wow = new WorldOfWarcraft();
    $wow->getServiceLocator()->setLocale($locale);
    $wow->getConnection()->setOptions(array(
        'defaults' => array(
            'region' => ZendFramework::REGION_EU,
            'locale' => array(
                ZendFramework::REGION_EU => ZendFramework::LOCALE_DE
            )
        )
    ));

    /* @var $guild bnetlib\Resource\Entity\Wow\Guild */
    $guild = $wow->getGuild(array(
        'name'   => 'Barmy',
        'realm'  => 'Die ewige Wacht',
        'locale' => ZendFramework::LOCALE_GB,
        'fields' => 'members'
    ));

    $wow->setReturnType(WorldOfWarcraft::RETURN_PLAIN);

    /* @var $realms array */
    $realms = $wow->getRealms(array(
        'region' => ZendFramework::REGION_US
    ));

    // Faction: Horda
    echo 'Faction: ' . $guild->getFactionLocale();

    $locale->setLocale(ZendFramework::LOCALE_CN);

    // Faction: 部落
    echo 'Faction: ' . $guild->getFactionLocale();

    /* @var $members bnetlib\Resource\Entity\Wow\Guild\Members */
    $members = $guild->getMembers();
    foreach ($members as $member) {
        /* @var $character bnetlib\Resource\Entity\Wow\Character */
        $character = $member->getCharacter();

        echo 'Name: ' $character->getName();

        if ($character->isMage() && $character->isUndead()) {
            /* @var $character bnetlib\Resource\Entity\Wow\Character */
            $character = $wow->getCharacter(
                $character,
                array(
                    'return' => WorldOfWarcraft::RETURN_OBJECT,
                    'fields' => array('titles', 'talents', 'professions')
                )
            );

            // Full Name: Thatguy Jenkins
            echo 'Full Name: ' . $character->getFullName();

            /* @var $titles bnetlib\Resource\Entity\Wow\Character\Titles */
            $titles = $character->getTitles();
            if ($titles->hasSelected()) {
                /* @var $selected bnetlib\Resource\Entity\Wow\Character\Title */
                $selected = $titles->getSelected();

                // Title: %s Jenkins
                echo 'Title: ' . $selected->getTitle();
            }

            /* @var $professions bnetlib\Resource\Entity\Wow\Character\Professions */
            $professions = $character->getProfessions();
            if ($professions->hasPrimaryProfession() && $professions->hasFirstAid()) {
                /* @var $firstAid bnetlib\Resource\Entity\Wow\Character\Profession */
                $firstAid = $professions->getById($professions::PROFESSION_FIRST_AID);

                echo ($firstAid->has(23787)) ? 'Yes' : 'No';
            }
        }
    }


License
-------

bnetlib is released under the MIT License. For the full copyright and license information see the [`LICENSE`](https://github.com/coss/bnetlib/blob/master/LICENSE) file.