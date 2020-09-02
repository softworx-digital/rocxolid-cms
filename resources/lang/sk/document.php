<?php

return [
    'column' => [
        'document_type_id' => 'Kategória šablón',
        'title' => 'Názov',
        'theme' => 'Téma',
        'valid_from' => 'Platnosť od',
        'valid_to' => 'Platnosť do',
        'page_element' => 'Element',
    ],
    'field' => [
        'document_type_id' => 'Kategória šablón',
        'documentType' => 'Kategória šablón',
        'title' => 'Názov',
        'theme' => 'Téma',
        'valid_from' => 'Platnosť od',
        'valid_to' => 'Platnosť do',
        'page_element' => 'Element',
        'dependencies' => 'Závislosti',
        'dependencies_filters' => 'Závislosti - filtre',
        'triggers' => 'Akcie',
        // @todo: nicer
        '_dependencies' => [
            'title' => 'Závislosť',
            'hint' => 'Na jej základe budú od používateľa požadované dodatočné údaje potrebné k vygenerovaniu dokumentu',
            'filter' => [
                'estate_type_id' => 'Typ nehnuteľnosti pre výber z hodnôt závislosti', // @todo: this doesn't belong here
            ],
        ],
        '_triggers' => [
            'title' => 'Akcia',
            'hint' => ' Definuje väzbu na ďalšie akcie spojené so generovaním dokumentu s touto šablónou',
        ],
    ],
    'button' => [
        'create-header' => 'Pridať hlavičku',
        'create-footer' => 'Pridať pätičku',
        'add-placeholder' => 'Pridať',
        'add-placeholder-close' => 'Pridať a zavrieť',
        'add-mutator-close' => 'Pridať a zavrieť',
    ],
    'model' => [
        'title' => [
            'singular' => 'Šablóna',
            'plural' => 'Šablóny',
        ],
    ],
    'action' => [
        'create' => 'Nová',
        'show' => 'Kompozícia',
        'preview' => 'Náhľad',
        'pdf' => 'PDF',
        'edit-header' => 'Výber hlavičky',
        'edit-footer' => 'Výber pätičky',
    ],
    'legend' => [
        'base' => 'Základné údaje',
        'dependencies' => 'Závislosti',
        'triggers' => 'Nadväzujúce akcie',
    ],
    'element-dependency' => [
        'none' => 'Bez požiadaviek',
    ],
    'element-mutator' => [
        'reverse' => [
            'title' => 'Obrátene',
            'hint' => 'Tento mutátor obráti vyznačený text',
        ],
    ],
    'text' => [
        'header' => 'Hlavička',
        'body' => 'Telo',
        'footer' => 'Pätička',
    ]
];