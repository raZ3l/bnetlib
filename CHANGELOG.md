Changelog
=========

1.2 (2012-06-23)
----------------

* Added Aura and Buzz connection adapter and the Icon resource.
* Added `getDate` Method for timestamps. Thats Method will return a `DateTime` object.
* Added `toArray` Method for every travesable object.
* Improved the Locale support in Entities.
* Moved all non-library files out of `/src/bnetlib` into `/data`

1.1 (2012-05-28)
----------------

* Added ServiceLocator and added service entries (from class map)
* Added Profession constants in Profession entity
* Added ServiceLocator feature for all resources
* Added Stub Connection, FixtureGenerator and generated fixtures
* Improved extendability of the Connection component.
* Moved exception marker to Exception/ and added new exceptions
* Moved Connection into own namespace
* Moved resource entities and configs into their own folder
* Renamed setConfig() to setOptions() and updated tests to use setOptions() instead of setConfig()
* Updated ClassMapGenerator
* Updated LocaleGenerator to support the new Connection namespace
* Updated tests and Game classes to work with the ServiceLocator
* Updated Resource Interfaces: EntityInterface is now ServiceLocatorAware and the ConsumeInterface now extends EntityInterface
* Fixed API doc error in Locale and changed $game argument to be optional
* Fixed php error and improved setter methods. The Service Locator will now unset shared instances before the overwrite takes place
* Fixed bug with Guild and Arena Team names, they are now rawurlencoded.

1.0.5 (2012-05-21)
------------------

* Improved Fixed error in DataAchievement, added missing getter for criteria
* Added missing Character Feed field + tests and fixed error in NewsEntry::consume() method.
* Added Feed field in character resource + tests

1.0.4 (2012-05-14)
------------------

* Added Rated Battleground Ladder resource + tests
* Added new keys for Item resource (see item_38268.json)
* Removed redundant code for config tests and added missing uni
* Improved extendability for Connection::request()
* Improved Guild::populate() and removed getter for Emblem array in Character/Guild.phpt tests
* Fixed error in Guild resource, Guild object is now LocaleAware
* Fixed issues with Zend\Http\Client::setConfig (zf2 commit: 25d922)
* Fixed Realms config error
* Fixed class name error for Guild Perks resource and Realms config
* Fixed typo for getRealms() and added test for Games to ensure that resources are setup correctly (tanks to Mike)


1.0.3 (2012-05-10)
------------------

* Fixed error for non json responses
* Added default file extension for File entity
* Added ItemSet resource + tests


1.0.2 (2012-05-08)
------------------

* Added PvP Area fields for Realms resource
* Fixed method error for Realms resource


1.0.1 (2012-05-06)
------------------

* Added Realms resource + tests
* Added news field (Guild resource) and Achievement resource
* Updated Resources: Character and Guild Achievements are now consumable
