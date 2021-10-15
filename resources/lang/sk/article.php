<?php

return [
    'model' => [
        'title' => [
            'singular' => 'Článok',
            'plural' => 'Články',
        ],
    ],
    'filter' => [
        'article_category_id' => 'Kategória',
    ],
    'column' => [
        'is_newsflash' => 'Novinka',
        'author_id' => 'Autor',
        'article_category_id' => 'Kategória',
        'date' => 'Dátum',
        'title' => 'Titulok',
        'tags' => 'Tagy',
        'slug' => 'Slug',
        //
        'image' => 'Obrázok v náhľade',
        'related' => 'Súvisiace články',
    ],
    'field' => [
        'is_newsflash' => 'Novinka',
        'author_id' => 'Autor',
        'article_category_id' => 'Kategória',
        'url' => 'URL',
        'date' => 'Dátum',
        'title' => 'Titulok',
        'tags' => 'Tagy',
        'slug' => 'Slug',
        'theme' => 'Téma',
        'meta_title' => '<title>',
        'meta_description' => '<meta name="description">',
        'meta_keywords' => '<meta name="keywords">',
        'perex' => 'Perex',
        'content' => 'Obsah',
        //
        'image' => 'Obrázok v náhľade',
        'headerImage' => 'Obrázok v hlavičke',
        'related' => 'Súvisiace články',
    ],
    'tab' => [
        'default' => 'Info',
        'composition' => 'Kompozícia',
    ],
    'panel' => [
        'data' => [
            'related' => [
                'heading' => 'Súvisiace články',
            ],
            'perex' => [
                'heading' => 'Perex',
            ],
        ],
        'access' => [
            'heading' => 'Prístupové údaje',
        ],
    ],
    'text' => [
        'header' => 'Hlavička',
        'body' => 'Obsah',
    ],
    'legend' => [
        'base' => 'Základné údaje',
    ],
];