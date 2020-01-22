<?php

return [
    'column' => [
        'localization_id' => 'Localization',
        'type' => 'Type',
        'name' => 'Name',
        'css_class' => 'CSS class(es)',
        'seo_url_slug' => 'SEO URL slug',
        'meta_title' => '<title>',
        'meta_description' => '<meta name="description">',
        'meta_keywords' => '<meta name="keywords">',
        'openGraphImage' => '<meta property="og:image">',
        'open_graph_title' => '<meta property="og:title">',
        'open_graph_description' => '<meta property="og:description">',
        'open_graph_image' => '<meta property="og:image">',
        'open_graph_type' => '<meta property="og:type">',
        'open_graph_url' => '<meta property="og:url">',
        'open_graph_site_name' => '<meta property="og:site_name">',
        'description' => 'Description',
        'page_element' => 'Element',
        // relations
        'localization' => 'Localization',
    ],
    'field' => [
        'localization_id' => 'Localization',
        'type' => 'Type',
        'name' => 'Heading',
        'css_class' => 'CSS class(es)',
        'seo_url_slug' => 'SEO URL slug',
        'meta_title' => '<title>',
        'meta_description' => '<meta name="description">',
        'meta_keywords' => '<meta name="keywords">',
        'openGraphImage' => '<meta property="og:image">',
        'open_graph_title' => '<meta property="og:title">',
        'open_graph_description' => '<meta property="og:description">',
        'open_graph_image' => '<meta property="og:image">',
        'open_graph_type' => '<meta property="og:type">',
        'open_graph_url' => '<meta property="og:url">',
        'open_graph_site_name' => '<meta property="og:site_name">',
        'description' => 'Description',
        'page_element' => 'Element',
        // relations
        'localization' => 'Localization',
        //
        'pivot-is_clone_page_element_instance' => 'Clone',
        'pivot-is_visible' => 'Show',
    ],
    'model' => [
        'title' => [
            'singular' => 'Page template',
            'plural' => 'Pages templates',
        ],
    ],
    'action' => [
        'show' => 'Composition',
        'repositoryOrderBy' => 'List',
        'selectPageElementClass' => 'Element class',
        'listPageElement' => 'Element class list',
        'preview' => 'Preview',
    ],
    'text' => [
        'element-already-set' => 'Element is already set'
    ],
    'category' => [
        'panels' => 'Panels',
        'containers' => 'Containers',
        'proxy' => 'Proxy elements',
    ],
];