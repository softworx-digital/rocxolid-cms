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
    ],
    'legend' => [
        'base' => 'Základné údaje',
        'dependencies' => 'Závislosti',
    ],
    'element-dependency' => [
        'none' => 'Bez požiadaviek',
    ],
];