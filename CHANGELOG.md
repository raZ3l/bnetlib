Changelog
=========

1.1 (2012-05-21)
------------------

* f0e1aa52fe8565b11359a50a716cf029c3901813 Moved exception marker to Exception/ and added new exceptions
* 802a7f300791f8cd3bb66145eb51b12d0102f090 Moved Connection into own namespace
* 24462a2665b5ff95cf17b5335cfc95a6ae4e547a Added ServiceLocator
* e46fb60f0db1be286df15c9f251acff516e500f4 Added service entries (from class map) and updated classmap
* a739ca8b7e160ef162916f008cf175667d825e70 Fixed error/removed optional arguments
* 7740796c61015a9320b8d40163ab8fc0237325bb Added Profession constants
* 71043a82b878496893f59868ff76b728bc6c1b64 EntityInterface is now ServiceLocatorAware and the ConsumeInterface now extends EntityInterface
* 96ac4785d55947c64c987ddc1c665343259f57f6 Fixed API doc error and changed $game argument to be optional
* 55e8946a8ba767a42ee40b4140777d976261155f Improved Service Locator get() method.
* f90e7a9649e8c432c67d1e5b9d15b899ae30c3c4 Improved extendability of the Connection component.
* 6d5ce8358f2a92cb94155276c2e829ff3c7755bb Added new exceptions
* 579076677dd2769f667ac6beb5dcf9801233d9a9 Fixed php error and improved setter methods. The Locator will now unset shared instances before the overwrite takes place.
* 8731cd84a9f56ac26b294e1d5c4e9bf6167dcfc7 Fixed error in exception name
* 93c0203900d618e9dce8ada3d91e441bf7751bae Added ServiceLocator feature for all resources
* 676df2b53af679d9131d370d0a5cfb5647eaea7c Fixed filename for Zend Framework adapter
* 664fb904670cc08148c5cb9a22791d9211883a8e Updated tests to work with the ServiceLocator
* 137c1a82d9ea565ab42a8e6d1096f28b7cf0c353 Updated Game classes to work with the ServiceLocator
* 16ba213f0829c42e29bde5cfe07ac62536d5baf6 Fixed bug with Guild and Arena Team names, they are now rawurlencoded.
* 3aeaf635398e86468ba80f66bee1949e605a8d9e Updated LocaleGenerator to support the new Connection namespace
* de53ad38b1dfe1ca3b1dd784f1bd110cea51e387 Added Stub Connection, FixtureGenerator and generated fixtures
* 800369cc0895861ff0ef09c95e5f6d6693856118 Updated tests to use setOptions() instead of setConfig()
* 30dda186480d1e87354266181e690bdef9a9dcb1 Renamed setConfig() to setOptions()
* 600b021bae40fc3f77782f67610c928e4e8c019e Moved resource entities and configs into their own folder.
* fac2dc23681e60c5ab7f3b5f6b43110391dcb5f4 Updated ClassMapGenerator

1.0.5 (2012-05-21)
------------------

* afc44f298ecdb8a990cdc74523ada68d12a4d565 Improved Fixed error in DataAchievement, added missing getter for criteria
* ef7a4ea7f665c46554d2f8ce2e5cc765b64768c9 Added missing Character Feed field + tests and fixed error in NewsEntry::consume() method.
* a2ea8c3f0af665e810fcb538b574c523ebd0bd48 Added Feed field in character resource + tests

1.0.4 (2012-05-14)
------------------

* f165f651fcb46b162a98ebd7b307cd6a391a6618 Improved extendability for Connection::request()
* 4c000426455d0e3f20ccaaf525b0113df08e73dd Improved Guild::populate() and removed getter for Emblem array in Character/Guild.php
* 063698014343dd9165aaf1798ad651c7971414c4 Removed redundant code for config tests
* 522a386b3888799dd1985b8ea48c3a4f117848ea Added missing unit tests
* 87edf6dd7b662873c6a980b03dadfae6f408f0b2 Added new keys for Item resource (see item_38268.json)
* c37c702e4e8d55ba384f8634f1f282ff3e3bccbe Fixed error in Guild resource, Guild object is now LocaleAware
* c52ba6e4b4b8f51637de442e7e6a618cc84a077f Added Rated Battleground Ladder resource + tests
* 02e4b2437b9b77c4395181f5629faa269648e841 Fixed issues with Zend\Http\Client::setConfig (zf2 commit: 25d922)
* 37ebb1af4e4e09749d6620ffc23004a3b46fb7db Added config test for Rated Battleground Ladder
* daf077e6f22649c3f702f0facc241b56d32d8853 Fixed Realms config error
* 521b492600f450c7a9482dc14d9404a01821bbd1 Fixed class name error for Guild Perks resource and Realms config
* 81306c3992c863c221f7bdb80367f370f29fdb22 Added test for WorldOfWarcraft to ensure that resources are setup correctly


1.0.3 (2012-05-10)
------------------

* e0816323dd69468c10ef632bbdfb9493f922d49a Fixed error for non json responses
* b7098f7ab3427530bab4c408b13013158395b9de Added default file extension
* d3992de973f6274eb3c7d6d29d589d05a11519af Added ItemSet resource + tests


1.0.2 (2012-05-08)
------------------

* 33c2c1513c31ccc13255a780c924da963d04b07e Added PvP Area fields for Realms resource
* 607938efd2c857e751cc5d36688c75c99ff541b5 Fixed method error for Realms resource


1.0.1 (2012-05-06)
------------------

* c07c4b1457f589a32c861171d3ebe10586e84341 Added Realms resource + tests
* 251aeaf79d2581775ff0c176f18f5a8d5f166db0 Character and Guild Achievements are now consumable
* 61352266d21bd5fea265abc2fda7705cd96c3749 Added news field (Guild resource) and Achievement resource


1.0 (2012-04-30)
----------------