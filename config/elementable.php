<?php

return [
    'default' => [
        // basic
        Softworx\RocXolid\CMS\Models\Text::class,
        Softworx\RocXolid\CMS\Models\Link::class,
        Softworx\RocXolid\CMS\Models\Gallery::class,
        Softworx\RocXolid\CMS\Models\IframeVideo::class,
        // containers
        Softworx\RocXolid\CMS\Models\HtmlWrapper::class,
        Softworx\RocXolid\CMS\Models\MainNavigation::class,
        Softworx\RocXolid\CMS\Models\RowNavigation::class,
        Softworx\RocXolid\CMS\Models\MainSlider::class,
        // panels
        Softworx\RocXolid\CMS\Models\CookieConsent::class,
        Softworx\RocXolid\CMS\Models\TopPanel::class,
        // Softworx\RocXolid\CMS\Models\SocialFooter::class, // not implemented
        Softworx\RocXolid\CMS\Models\FooterNavigation::class,
        Softworx\RocXolid\CMS\Models\FooterNote::class,
        Softworx\RocXolid\CMS\Models\StatsPanel::class,
        // forms
        Softworx\RocXolid\CMS\Models\Newsletter::class,
        Softworx\RocXolid\CMS\Models\Contact::class,
        Softworx\RocXolid\CMS\Models\SearchEngine::class,
        Softworx\RocXolid\CMS\Models\LoginRegistration::class,
        Softworx\RocXolid\CMS\Models\ForgotPassword::class,
        Softworx\RocXolid\CMS\Models\UserProfile::class,
        // Softworx\RocXolid\CMS\Models\ShoppingCart::class, // some controller problem
        Softworx\RocXolid\CMS\Models\ShoppingCheckout::class,
        Softworx\RocXolid\CMS\Models\ShoppingAfter::class,
        // lists
        Softworx\RocXolid\CMS\Models\ProductList::class,
        Softworx\RocXolid\CMS\Models\ArticleList::class,
        // proxies
        Softworx\RocXolid\CMS\Models\ProxyProduct::class,
        Softworx\RocXolid\CMS\Models\ProxyArticle::class,
    ],
    'article' => [
        Softworx\RocXolid\CMS\Models\Text::class,
        Softworx\RocXolid\CMS\Models\Link::class,
        Softworx\RocXolid\CMS\Models\Gallery::class,
        Softworx\RocXolid\CMS\Models\IframeVideo::class,
    ],
];