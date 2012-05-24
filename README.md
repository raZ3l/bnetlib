bnetlib [![Build Status](https://secure.travis-ci.org/coss/bnetlib.png?branch=master)](http://travis-ci.org/coss/bnetlib)
=======

bnetlib is an object-oriented interface for the Battle.net REST API. It tries to keep a direct mapping to the actual resource names and response values.


Requirements
------------

bnetlib requires PHP 5.3.3+ and depends on [`Zend\Http`](https://github.com/zendframework/zf2/).


Features
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

bnetlib is PSR-0 compliant and provides a [class map](https://github.com/coss/bnetlib/blob/master/src/bnetlib/_classmap.php). You may use any PSR-0 compliant/class map autoloader you like (e.g. [`Zend\Loader`](https://github.com/zendframework/zf2/)) or use the fallback [`_autoload.php`](https://github.com/coss/bnetlib/blob/master/src/bnetlib/_autoload.php).


Example
-------

    use bnetlib\Locale\Locale;
    use bnetlib\WorldOfWarcraft;

    $wow = new WorldOfWarcraft();
    $wow->getConnection()->setConfig(array(
        'defaults' => array(
            'region' => Connection::REGION_EU,
            'locale' => array(
                Connection::REGION_EU => Connection::LOCALE_DE
            )
        )
    ));

    // gettype($guild) -> object (bnetlib\Resource\Wow\Guild)
    $guild = $wow->getGuild(array(
        'name'   => 'Barmy',
        'realm'  => 'Die ewige Wacht',
        'region' => Connection::REGION_EU,
        'locale' => Connection::LOCALE_DE,
        'fields' => 'members'
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


Basic Documentation
-------------------

### Connection

    use Zend\Http\Client;
    use bnetlib\Connection;

    $config = array(
        /**
         * Force SSL (https) connection.
         */
        'securerequests' => false,
        /**
         * Include response headers in return value and save the last response headers.
         * @see Connection::getLastResponseHeaders()
         */
        'responseheader' => true,
        /**
         * Application authentication
         */
        'keys' => array(
            'public'  => null,
            'private' => null
        ),
        /**
         * These default values will be used if not supplied. You can overwrite the default values per request,
         * by passing the 'region' or 'locale' key.
         */
        'defaults' => array(
            'region' => null,
            'locale' => array(
                Connection::REGION_US => null,
                Connection::REGION_EU => null,
                Connection::REGION_KR => null,
                Connection::REGION_TW => null,
                Connection::REGION_CN => null
            )
        )
    );

    /**
     * You may pass an Client instance and config array.
     */
    $client     = new Client();
    $connection = new Connection($client, $config);
    $connection->setConfig($config);

### World of Warcraft

    use bnetlib\Connection;
    use bnetlib\WorldOfWarcraft;
    use bnetlib\Exception\CacheException;

    /**
     * You may pass an Connection instance (must implement ConnectionInterface).
     */
    $wow    = new WorldOfWarcraft();

    /**
     * You can overwrite resource classes and/or configs by using the ::setResource() method.
     * The value of 'Character' may be an array or string. If you pass a string as value, the value will
     * be interpreted as a class name.
     */
    $wow->setResource(array(
        'Character' => array(
            'class'  => 'Namespace\Class\Character',
            'config' => 'Namespace\Config\Character'
    )));

    /**
     * Sets the return type for resources (::RETURN_PLAIN or ::RETURN_OBJECT).
     */
    $wow->setReturnType(WorldOfWarcraft::RETURN_OBJECT);

    /**
     * Returns the supported locales for a region.
     */
    $wow->getSupportedLocale(Connection::REGION_US);

    /**
     * Requesting resources and how it works:
     *   - Validate method name against $resource array
     *   - Lazy load resource config
     *   - Combine and validate request parameters
     *     - Up to 2 parameters are allowed (array or object implementing ConsumeInterface)
     *     - Manipulate parameters
     *     - Build URL
     *   - Retrieve data from battle.net API
     *   - Parse JSON and identify any errors (json error, response error)
     *   - Create response object or array and return it
     *
     * Specials keys:
     *   - region       = Set default region or per request
     *   - locale       = Not nessesary, may use default locale
     *   - lastmodified = RFC 1123 compliant string or timestamp
     *   - return       = Return type, ::RETURN_PLAIN or ::RETURN_OBJECT
     */
    $realms = $wow->getRealms(array('region' => Connection::REGION_EU));

### Consuming Resource Objects

bnetlib allows consuming objects to supply request arguments. If you wish to overwrite a consumed array key, simply pass another array with that key as request argument.

The following classes are consumable:

* `bnetlib\Resource\Wow\Auction` > Auction file URL
* `bnetlib\Resource\Wow\AuctionData` > Realm name
* `bnetlib\Resource\Wow\Achievements\Achievement` > Achievement Id
* `bnetlib\Resource\Wow\Battlegroup` > Battlegroup name as slug
* `bnetlib\Resource\Wow\Character` > Character name, Realm name and thumbnail URL
* `bnetlib\Resource\Wow\Character\Glyph` > Item Id
* `bnetlib\Resource\Wow\Character\Guild` > Realm name and Guild name
* `bnetlib\Resource\Wow\Character\Record` > Realm name as slug, Battlegroup name as slug and Character name
* `bnetlib\Resource\Wow\Guild` > Realm name
* `bnetlib\Resource\Wow\Guild\NewsEntry` > Item Id (if set) and Character name (if set)
* `bnetlib\Resource\Wow\Item\Reward` > Item Id

Example:

    $auction = $wow->getAuction();
    $data    = $wow->getAuctionData($auction);

### Exceptions

bnetlib implements the Marker interface pattern for exceptions, so every exception thrown by this library can be caught by catching `bnetlib\Exception`. Exceptions thrown during the request implement another marker called `bnetlib\Exception\ResponseException`. Visit Blizzard's [API documentation](http://blizzard.github.com/api-wow-docs/#idp40928) for more details.

The following exception may be thrown during the request:

* `CacheException` > 'lastmodified' key passed and cache is still valid.
* `JsonException` > Wrapper for json_decode errors, see [json_last_error](http://www.php.net/manual/en/function.json-last-error.php)
* `InvalidAppException` > Invalid Application
* `InvalidAppPermissionsException` > Invalid application permissions
* `InvalidAppSignatureException` > Invalid application signature
* `InvalidAuthHeaderException` > Invalid authentication header
* `PageNotFoundException` > When in doubt, blow it up. (page not found)
* `RequestBlockedException` > Access denied, please contact api-support@blizzard.com
* `RequestsThrottledException` > If at first you don't succeed, blow it up again. (too many requests)
* `ServerErrorException` > Have you not been through enough? Will you continue to fight what you cannot defeat? (something unexpected happened)
* `UnexpectedResponseException` > Unable to detect reason

Example:

    try {
        $wow->getCharacter(/*some data*/);
    } catch (bnetlib\Exception\CacheException $e) {
        // Cache is still valid.

        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    } catch (bnetlib\Exception\PageNotFoundException $e) {
        // Character not found - typo?

        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    } catch (bnetlib\Exception\RequestsThrottledException $e) {
        // You've send to many requests, wait some time and try again.

        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    } catch (bnetlib\Exception\RequestBlockedException $e) {
        // You've been banned :C

        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    } catch (bnetlib\Exception\ServerErrorException $e) {
        // Server error, try again.

        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    } catch (bnetlib\Exception\ResponseException $e) {
        // Fallback, cache every other error

        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    }


Todo
----

* Add composer support
* Write (better) Documentation (also improve api docs)
* Improve Locale support (stats, reforged stats etc.)


License
-------

bnetlib is released under the MIT License. For the full copyright and license information see the [`LICENSE`](https://github.com/coss/bnetlib/blob/master/LICENSE) file.