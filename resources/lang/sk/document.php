<?php

return [
    'column' => [
        'document_type_id' => 'Typ dokumentu',
        'title' => 'Názov',
        'theme' => 'Množina šablón',
        'valid_from' => 'Platnosť od',
        'valid_to' => 'Platnosť do',
        'page_element' => 'Element',
    ],
    'field' => [
        'document_type_id' => 'Typ dokumentu',
        'title' => 'Názov',
        'theme' => 'Množina šablón',
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
    ],
    'model' => [
        'title' => [
            'singular' => 'Dokument',
            'plural' => 'Dokumenty',
        ],
    ],
    'action' => [
        'show' => 'Kompozícia',
        'preview' => 'Náhľad',
        'pdf' => 'PDF',
        'edit-header' => 'Výber hlavičky dokumentu',
        'edit-footer' => 'Výber pätičky dokumentu',
    ],
    'legend' => [
        'base' => 'Základné údaje',
        'dependencies' => 'Závislosti',
    ],
    'element-dependency' => [
        'none' => 'Bez požiadaviek',
    ],
    'text' => [
        'header' => 'Hlavička dokumentu',
        'body' => 'Telo dokumentu',
        'footer' => 'Pätička dokumentu',
    ]
];