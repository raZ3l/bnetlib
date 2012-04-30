bnetlib
=======

bnetlib is an object-oriented interface for the Battle.net REST API. It tries to keep a direct mapping to the actual resource names and response values.

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

    $guild = $wow->getGuild(array(
        'realm'  => 'Blackrock',
        'name'   => 'Roots of Dragonmaw',
        'region' => Connection::REGION_EU,
        'locale' => Connection::LOCALE_DE,
        'fields' => 'members'
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