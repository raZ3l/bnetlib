bnetlib 1.1 [![Build Status](https://secure.travis-ci.org/coss/bnetlib.png?branch=master)](http://travis-ci.org/coss/bnetlib)
===========

bnetlib is an object-oriented interface for the Battle.net REST API. It tries to keep a direct mapping to the actual resource names and response values.

**Diablo preview:** Blizzard just released a preview for the [Diablo III API](http://us.battle.net/wow/en/forum/topic/5271598804?page=1#1). You can find a working implementation (in combination with the stub connection) for the latest preview under the [`diablo-preview`](https://github.com/coss/bnetlib/tree/diablo-preview) branch.

> Note: The version 1.1 contains some BC breaks, read the [`UPGRADE.md`](https://github.com/coss/bnetlib/blob/master/UPGRADE.md) for more informations.

Requirements
------------

bnetlib requires PHP 5.3.3+ and depends on [`Zend\Http`](https://github.com/zendframework/zf2/).


Features
--------

* If-Modified-Since Header
* Application authentication
* Returns simple array or full blown object
* Stub connection for testing and development
* Locale string helper for class names, race names, etc. etc. etc.


Resources
---------

### World of Warcraft and Diablo III

**World of Warcraft:**

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

    use bnetlib\Diablo;
    use bnetlib\Locale\Locale;
    use bnetlib\WorldOfWarcraft;
    use bnetlib\Connection\ConnectionInterface;
    use bnetlib\Resource\EntityWow\Character\Professions;

    /**
     * Both games share the same interface
     */
    $d3  = new Diablo();
    $wow = new WorldOfWarcraft();
    $wow->getConnection()->setOptions(array(
        'defaults' => array(
            'region' => ConnectionInterface::REGION_EU,
            'locale' => array(
                ConnectionInterface::REGION_EU => ConnectionInterface::LOCALE_DE
            )
        )
    ));

    /* @var $guild bnetlib\Resource\EntityWow\Guild */
    $guild = $wow->getGuild(array(
        'name'   => 'Barmy',
        'realm'  => 'Die ewige Wacht',
        'region' => ConnectionInterface::REGION_EU,
        'locale' => ConnectionInterface::LOCALE_DE,
        'fields' => 'members'
    ));

    $wow->setReturnType(WorldOfWarcraft::RETURN_PLAIN);

    /* @var $realms array */
    $realms = $wow->getRealms(array(
        'region' => ConnectionInterface::REGION_EU
    ));

    /**
     * You can pass a game short name as second argument. By default 'wow' will be used.
     * Example: new Locale(ConnectionInterface::LOCALE_DE, WorldOfWarcraft::SHORT_NAME);
     */
    $locale = new Locale(ConnectionInterface::LOCALE_ES);
    $guild->setLocale($locale)
    /**
     * Note: The Service Locator is Locale aware. If you've set a Locale class,
     *       the locator will pass it into every class it creates.
     *
     * $wow->getServiceLocator()->setLocale($locale);
     */

    // Faction: Horda
    echo 'Faction: ' . $guild->getFactionLocale();

    $locale->setLocale(ConnectionInterface::LOCALE_CN);

    // Faction: 部落
    echo 'Faction: ' . $guild->getFactionLocale();

    /* @var $members bnetlib\Resource\EntityWow\Guild\Members */
    $members = $guild->getMembers();
    foreach ($members as $member) {
        /* @var $character bnetlib\Resource\EntityWow\Character */
        $character = $member->getCharacter();
        echo 'Name: ' $character->getName();

        if ($character->isMage() && $character->isUndead()) {
            // Consumes the old Character object and requests a new one with fields.
            /* @var $character bnetlib\Resource\EntityWow\Character */
            $character = $wow->getCharacter(
                $character,
                array(
                    // Note: The default return type is still ::RETURN_PLAIN!
                    'return' => WorldOfWarcraft::RETURN_OBJECT,
                    'fields' => array('titles', 'talents', 'professions')
                )
            );

            /* @var $titles bnetlib\Resource\EntityWow\Character\Titles */
            $titles = $character->getTitles();
            if ($titles->hasSelected()) {
                $selected = $titles->getSelected();

                // Title: %s the Insane
                echo 'Title: ' . $selected->getTile();

                // Title: Thatguy the Insane
                echo 'Title: ' . $selected->getFullName();
            }

            /* @var $professions bnetlib\Resource\EntityWow\Character\Professions */
            $professions = $character->getProfessions();
            if ($professions->hasPrimaryProfession() && $professions->hasFirstAid()) {
                /* @var $firstAid bnetlib\Resource\EntityWow\Character\Profession */
                $firstAid = $professions->getById(Professions::PROFESSION_FIRST_AID);

                echo $firstAid->has(23787);
            }
        }
    }


Basic Documentation
-------------------

### Connection

The Connection is used to communicate with the battle.net API via thrid-party HTTP libraries. As of Version 1.1, bnetlib ships with one ([`Zend\Http`](https://github.com/zendframework/zf2/) library adapter and a Stub adapter for development and testing.

    $options = array(
        /**
         * Enforce SSL (HTTPS) connection.
         */
        'securerequests' => false,
        /**
         * Include response headers in return value and save the last response headers.
         * @see ::getLastResponseHeaders()
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
         * These default values will be used if not supplied. You can overwrite the default values
         * per request, by passing the 'region' or 'locale' key.
         */
        'defaults' => array(
            'region' => null,
            'locale' => array(
                ConnectionInterface::REGION_US => null,
                ConnectionInterface::REGION_EU => null,
                ConnectionInterface::REGION_KR => null,
                ConnectionInterface::REGION_TW => null,
                ConnectionInterface::REGION_CN => null
            )
        )
        /**
         * These options are only available for the Stub Connection.
         */
        'stub' => array(
            /**
             * Keep fixture data in memory after loading
             */
            'memory' => true,
            /**
             * Path to fixtures. bnetlib ships with default fixtures,
             * but you can generate own by using the bin/FixtureGenerator.php.
             */
            'path'   => 'path/to/bnetlib/Data/Fixtures',
        )
    );

    /**
     * You may pass an Client/Browser instance and a options array.
     */
    use Zend\Http\Client;
    use bnetlib\Connection\ZendFramework;

    $client     = new Client();
    $connection = new ZendFramework(Client $client, array $options);


    use bnetlib\ServiceLocator;
    use bnetlib\Connection\Stub;
    use bnetlib\ServiceLocatorInterface;

    /**
     * Note: The Stub connection uses the ServiceLocator to load the fixtures based on the service key.
     *       If you've overwritten any configuration class, you must to pass the ServiceLocator in order
     *       to be able to work with the Stub connection.
     */
    $client     = new ServiceLocator();
    $connection = new Stub(ServiceLocatorInterface $client, array $options);

    /**
     * Sets option values
     */
    $connection->setOptions($options);

### World of Warcraft

    use bnetlib\WorldOfWarcraft;
    use bnetlib\Connection\ConnectionInterface;
    use bnetlib\ServiceLocator\ServiceLocatorInterface;

    /**
     * You may pass an Connection and Service Locator instance.
     * By default `bnetlib\Connection\ZendFramework` and `ServiceLocator\ServiceLocator` will be used.
     */
    $wow = new WorldOfWarcraft(ConnectionInterface $connection, ServiceLocatorInterface $serviceLocator);

    /**
     * Getter for the Connection object
     */
    $wow->getConnection();

    /**
     * Getter for the Service Locator object
     */
    $wow->getServiceLocator();

    /**
     * Sets the return type for resources (::RETURN_PLAIN or ::RETURN_OBJECT).
     */
    $wow->setReturnType(WorldOfWarcraft::RETURN_OBJECT);

    /**
     * Returns the supported locales for a region.
     */
    $wow->getSupportedLocale(ConnectionInterface::REGION_US);

    /**
     * Requesting resources and how it works:
     *   - Validate method name against $resource array
     *   - Load resource configuration via Service Locator
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
    $realms = $wow->getRealms(array('region' => ConnectionInterface::REGION_EU));

### Consuming Resource Objects

bnetlib allows consuming objects to supply request arguments. If you wish to overwrite a consumed array key, simply pass another array with that key as request argument.

**The following classes are consumable:**

* `bnetlib\Resource\EntityWow\Auction` > Auction file URL
* `bnetlib\Resource\EntityWow\AuctionData` > Realm name
* `bnetlib\Resource\EntityWow\Achievements\Achievement` > Achievement Id
* `bnetlib\Resource\EntityWow\Battlegroup` > Battlegroup name as slug
* `bnetlib\Resource\EntityWow\Character` > Character name, Realm name and thumbnail URL
* `bnetlib\Resource\EntityWow\Character\Glyph` > Item Id
* `bnetlib\Resource\EntityWow\Character\Guild` > Realm name and Guild name
* `bnetlib\Resource\EntityWow\Character\Record` > Realm name as slug, Battlegroup name as slug and Character name
* `bnetlib\Resource\EntityWow\Guild` > Realm name
* `bnetlib\Resource\EntityWow\Guild\NewsEntry` > Item Id (if set) and Character name (if set)
* `bnetlib\Resource\EntityWow\Item\Reward` > Item Id

**Example:**

    $auction = $wow->getAuction();
    $data    = $wow->getAuctionData($auction);

### Exceptions

bnetlib implements the Marker interface pattern for exceptions, that means that every exception thrown by this library can be caught by catching `Exception\ExceptionInterface`. Exceptions thrown during the request implement another marker called `Exception\ResponseExceptionInterface`. The Exception Code will be set to the returned HTTP Status Code, except for `Exception\ClientException`. Visit Blizzard's [API documentation](http://blizzard.github.com/api-wow-docs/#idp40928) for more details.

**The following exceptions may be thrown during the request:**

* `CacheException` > 'lastmodified' key passed and cache is still valid.
* `JsonException` > Wrapper for json_decode errors, see [json_last_error](http://www.php.net/manual/en/function.json-last-error.php)
* `ClientException` > Intercepts all exceptions thrown by the client, use `$e->getPrevious()`
* `InvalidAppException` > Invalid Application
* `InvalidAppPermissionsException` > Invalid application permissions
* `InvalidAppSignatureException` > Invalid application signature
* `InvalidAuthHeaderException` > Invalid authentication header
* `PageNotFoundException` > When in doubt, blow it up. (page not found)
* `RequestBlockedException` > Access denied, please contact api-support@blizzard.com
* `RequestsThrottledException` > If at first you don't succeed, blow it up again. (too many requests)
* `ServerErrorException` > Have you not been through enough? Will you continue to fight what you cannot defeat? (something unexpected happened)
* `ServerUnavailableException` > For HTTP 503 Service Unavailable responses
* `UnexpectedResponseException` > Unexpected status code returned
* `UnknownErrorException` > Unable to detect reason

**Example:**

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
    } catch (bnetlib\Exception\ServerUnavailableException $e) {
        // Server unavailable, try again later.
        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    } catch (bnetlib\Exception\ClientException $e) {
        // Catched Client Exception
        $e = $e->getPrevious();
        // so something...
    } catch (bnetlib\Exception\ResponseExceptionInterface $e) {
        // Fallback, cache every other error
        $status  = $e->getCode();
        $headers = $wow->getConnection->getLastResponseHeaders();
        // so something...
    }

### ServiceLocator

The Service Locator is used to create every resource specific instance. If you wish to extend `bnetlib`, simply overwrite a service entry in `ServiceLocator\ServiceLocator` or create your own Locator using the `ServiceLocator\ServiceLocatorInterface`.

After the instantiation is done, the locator will try to inject the ServiceLocator itself and Locale object (if set), if the object is Service Locator or Locale aware.

> Note: Every Resource class must implement `Resource\ResourceInterface` and every Configuration class must implement `Resource\ConfigurationInterface`.

    use bnetlib\Locale\Locale;
    use bnetlib\ServiceLocator\ServiceLocator;

    $locator = new ServiceLocator();
    $locator->set('wow.entity.character', 'You\Namespace\Character');
    $locator->fromArray(array(
        'wow.entity.guild'     => 'You\Namespace\Guild',
        'wow.entity.character' => 'You\Namespace\Character',
    ));

    /**
     * Setter for Locale
     */
    $locator->setLocale(new Locale('de_DE'));

Todo
----

* Add composer support
* Write (better) Documentation (also improve api docs)
* Improve Locale support (stats, reforged stats etc.)


License
-------

bnetlib is released under the MIT License. For the full copyright and license information see the [`LICENSE`](https://github.com/coss/bnetlib/blob/master/LICENSE) file.