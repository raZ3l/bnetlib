<?php

return array(
    'games' => array(
        'wow' => 'bnetlib\WorldOfWarcraft'
    ),
    'default_locale' => 'en_US',
    'filepath' => __DIR__ . '%1$stmp%1$sLocale%1$s%2$s%1$s%3$s.php',
    'locale' => array(
        'wow' => array(
            'en_US' => array(
                'gender'    => array(0 => 'male', 1 => 'female'),
                'faction'   => array(0 => 'Alliance', 1 => 'Horde'),
                // Resource|Contentkey:key:value
                'itemclass' => 'ItemClasses|classes:class:name',
                'race'      => 'CharacterRaces|races:id:name',
                'class'     => 'CharacterClasses|classes:id:name'
            ),
            'es_MX' => array(
                // gender:  missing
                'faction' => array(0 => 'Alianza', 1 => 'Horda')
            ),
            'en_GB' => array(
                // gender:  same as en_US
                // faction: same as en_US
            ),
            'es_ES' => array(
                // gender:  missing
                'faction' => array(0 => 'Alianza', 1 => 'Horda')
            ),
            'fr_FR' => array(
                // gender:  missing
                // faction: same as en_US
            ),
            'ru_RU' => array(
                // gender:  missing
                'faction' => array(0 => 'АЛЬЯНС', 1 => 'ОРДА')
            ),
            'de_DE' => array(
                'gender'  => array(0 => 'männlich', 1 => 'weiblich'),
                'faction' => array(0 => 'Allianz', 1 => 'Horde')
            ),
            'ko_KR' => array(
                // gender:  missing
                'faction' => array(0 => '얼라이언스', 1 => '호드')
            ),
            'zh_TW' => array(
                // gender:  missing
                'faction' => array(0 => '聯盟', 1 => '部落')
            ),
            'zh_CN' => array(
                // gender:  missing
                'faction' => array(0 => '联盟', 1 => '部落')
            ),
            'it_IT' => array(
                // gender:  missing
                'faction' => array(0 => 'Alleanza', 1 => 'Orda')
            ),
            'pt_PT' => array(
                // gender:  missing
                'faction' => array(0 => 'Aliança', 1 => 'Horda')
            ),
            'pt_BR' => array(
                // gender:  missing
                'faction' => array(0 => 'Aliança', 1 => 'Horda')
            )
        )
    )
);