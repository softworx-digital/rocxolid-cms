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
        'title' => 'Názov',
        'theme' => 'Téma',
        'valid_from' => 'Platnosť od',
        'valid_to' => 'Platnosť do',
        'page_element' => 'Element',
        '_dependencies' => [
            'dependency' => 'Závislosť (na základe ktorej budú od používateľa požadované údaje)',
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