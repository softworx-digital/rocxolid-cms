<?php

return [
    'column' => [
        'type' => 'Typ',
        'title' => 'Názov',
        '_type' => [
            'boolean' => 'Áno / nie hodnota',
            'integer' => 'Celočíselná hodnota',
            'decimal' => 'Číselná hodnota',
            'string' => 'Reťazec',
            'text' => 'Text',
            'date' => 'Dátum',
            'enum' => 'Exkluzívny výber z množiny textov',
            'set' => 'Inkluzívny výber z množiny textov',
        ],
    ],
    'field' => [
        'type' => 'Typ',
        'title' => 'Názov',
        'is_required' => 'Povinná hodnota',
        'default_value_boolean' => 'Predvyplnená odpoveď',
        'default_value_integer' => 'Predvyplnená hodnota',
        'default_value_decimal' => 'Predvyplnená hodnota',
        'default_value_string' => 'Predvyplnená hodnota',
        'default_value_text' => 'Predvyplnená hodnota',
        'default_value_date' => 'Predvyplnený dátum',
        'min' => 'Minimálna hodnota',
        'max' => 'Maximálna hodnota',
        'yes_title' => 'Text pre výber kladnej odpovede',
        'no_title' => 'Text pre výber zápornej odpovede',
        'values' => 'Hodnoty',
        'conjunction' => 'Spojka pre viacero hodnôt',
        '_values' => [
            'value' => 'Text',
            'is_default_value' => 'Predvolené',
        ],
    ],
    'button' => [
        'create-new' => 'Vytvoriť novú hlavičku',
        'detach' => 'Bez hlavičky',
    ],
    'model' => [
        'title' => [
            'singular' => 'Vstupný údaj šablóny',
            'plural' => 'Vstupné údaje šablón',
        ],
    ],
    'legend' => [
        'base' => 'Základné údaje',
        'rules' => 'Pravidlá',
        'values' => 'Množina hodnôt',
        'additional' => 'Doplňujúce údaje',
    ],
    'type' => [
        'boolean' => 'Áno / nie hodnota',
        'integer' => 'Celočíselná hodnota',
        'decimal' => 'Číselná hodnota',
        'string' => 'Reťazec',
        'text' => 'Text',
        'date' => 'Dátum',
        'enum' => 'Exkluzívny výber z množiny textov',
        'set' => 'Inkluzívny výber z množiny textov',
    ],
    'boolean' => [
        'yes' => 'Áno',
        'no' => 'Nie',
    ],
    'date' => [
        'null' => 'Nepredvyplniť dátumom',
        'today' => 'Aktuálny dátum',
    ],
    'text' => [
        'cannot-destroy-assigned' => 'Tento vstupný údaj nie je možné vymazať vzhľadom na to, že je použitý ako závislosť v nasledovných šablónach:',
        'cannot-destroy-release' => 'Pre jeho zmazanie je potrebné ho zo závislostí šablón uvoľniť.',
    ],
];