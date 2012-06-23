<?php

return array(
    'games' => array(
        'wow' => 'bnetlib\WorldOfWarcraft'
    ),
    'default_locale' => 'en_US',
    'filepath' => dirname(__DIR__) . '%1$sdata%1$sLocale%1$s%2$s%1$s%3$s.php',
    'locale' => array(
        'wow' => array(
            'en_US' => array(
                'gender'      => array(
                    0 => 'male',
                    1 => 'female',
                ),
                'faction'     => array(
                    0 => 'Alliance',
                    1 => 'Horde',
                ),
                'auction'     => array(
                    1 => 'Short',
                    2 => 'Medium',
                    3 => 'Long',
                    4 => 'Very Long',
                ),
                'itemquality' => array(
                    0 => 'Poor',
                    1 => 'Common',
                    2 => 'Uncommon',
                    3 => 'Rare',
                    4 => 'Epic',
                    5 => 'Heirloom',
                    6 => 'Artifact',
                    7 => 'Legendary',
                ),
                'pvpareastatus' => array(
                    -1 => 'Unknown',
                    0  => 'Idle',
                    1  => 'Populating',
                    2  => 'Active',
                    3  => 'Concluded',
                ),
                'standing' => array(
                    0  => 'Hated',
                    1  => 'Hostile',
                    2  => 'Unfriendly',
                    3  => 'Neutral',
                    4  => 'Friendly',
                    5  => 'Honored',
                    6  => 'Revered',
                    7  => 'Exalted',
                ),
                // Resource|Contentkey:key:value
                'itemclass' => 'ItemClasses|classes:class:name',
                'race'      => 'CharacterRaces|races:id:name',
                'class'     => 'CharacterClasses|classes:id:name'
            ),
            'es_MX' => array(
                // gender:  missing
                'faction' => array(
                    0 => 'Alianza',
                    1 => 'Horda',
                ),
            ),
            'en_GB' => array(
                // gender:  same as en_US
                // faction: same as en_US
            ),
            'es_ES' => array(
                // gender:  missing
                'faction' => array(
                    0 => 'Alianza',
                    1 => 'Horda',
                ),
                'itemquality' => array(
                    0 => 'Pobre',
                    1 => 'Común',
                    2 => 'Poco Común',
                    3 => 'Raro',
                    4 => 'Épica',
                    5 => 'Reliquia',
                    6 => 'Artefacto',
                    7 => 'Legendaria',
                )
            ),
            'fr_FR' => array(
                // gender:  missing
                // faction: same as en_US
                'itemquality' => array(
                    0 => 'Médiocre',
                    1 => 'Classique',
                    2 => 'Bonne',
                    3 => 'Rare',
                    4 => 'Épique',
                    5 => 'Héritage',
                    6 => 'Artefact',
                    7 => 'Légendaire',
                ),
            ),
            'ru_RU' => array(
                // gender:  missing
                'faction' => array(
                    0 => 'АЛЬЯНС',
                    1 => 'ОРДА',
                ),
                'itemquality' => array(
                    0 => 'Низкий',
                    1 => 'Обычный',
                    2 => 'Необычный',
                    3 => 'Редкий',
                    4 => 'Эпический',
                    5 => 'Фамильная черта',
                    6 => 'Артефакт',
                    7 => 'Легендарный',
                ),
            ),
            'de_DE' => array(
                'gender'  => array(
                    0 => 'männlich',
                    1 => 'weiblich',
                ),
                'faction' => array(
                    0 => 'Allianz',
                    1 => 'Horde',
                ),
                'auction' => array(
                    1 => 'Kurz',
                    2 => 'Medium',
                    3 => 'Lange',
                    4 => 'Sehr lange',
                ),
                'itemquality' => array(
                    0 => 'Schlecht',
                    1 => 'Verbreitet',
                    2 => 'Selten',
                    3 => 'Rar',
                    4 => 'Episch',
                    5 => 'Erbstück',
                    6 => 'Artefakt',
                    7 => 'Legendär',
                ),
                'pvpareastatus' => array(
                    -1 => 'Unbekannt',
                    0  => 'Inaktiv',
                    1  => 'Bevölkern',
                    2  => 'Aktiv',
                    3  => 'Entschieden',
                ),
                'standing' => array(
                    0  => 'Hasserfüllt',
                    1  => 'Feindselig',
                    2  => 'Unfreundlich',
                    3  => 'Neutral',
                    4  => 'Freundlich',
                    5  => 'Wohlwollend',
                    6  => 'Respektvoll',
                    7  => 'Ehrfürchtig',
                ),
            ),
            'ko_KR' => array(
                // gender:  missing
                'faction' => array(
                    0 => '얼라이언스',
                    1 => '호드',
                ),
            ),
            'zh_TW' => array(
                // gender:  missing
                'faction' => array(
                    0 => '聯盟',
                    1 => '部落',
                ),
            ),
            'zh_CN' => array(
                // gender:  missing
                'faction' => array(
                    0 => '联盟',
                    1 => '部落',
                ),
            ),
            'it_IT' => array(
                // gender:  missing
                'faction' => array(
                    0 => 'Alleanza',
                    1 => 'Orda',
                ),
            ),
            'pt_PT' => array(
                // gender:  missing
                'faction' => array(
                    0 => 'Aliança',
                    1 => 'Horda',
                ),
                'itemquality' => array(
                    0 => 'Pobre',
                    1 => 'Comum',
                    2 => 'Incomum',
                    3 => 'Raro',
                    4 => 'Épico',
                    5 => 'Herança',
                    6 => 'Artefato',
                    7 => 'Lendário',
                ),
            ),
            'pt_BR' => array(
                // gender:  missing
                'faction' => array(
                    0 => 'Aliança',
                    1 => 'Horda',
                ),
                'itemquality' => array(
                    0 => 'Pobre',
                    1 => 'Comum',
                    2 => 'Incomum',
                    3 => 'Raro',
                    4 => 'Épico',
                    5 => 'Herança',
                    6 => 'Artefato',
                    7 => 'Lendário',
                ),
            ),
        ),
    ),
);