<?php

namespace Softworx\RocXolid\CMS\Models\Tables\HtmlWrapper;

// rocXolid table columns
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;
use Softworx\RocXolid\Tables\Columns\Type\ImageRelation;
// rocXolid table buttons
use Softworx\RocXolid\Tables\Buttons\Type\ButtonAnchor;
use Softworx\RocXolid\CMS\Models\Tables\Columns\Type\PageRelation;
// rocXolid CMS tables
use Softworx\RocXolid\CMS\Models\Tables\AbstractCrudCMSTable;

/**
 *
 */
class Index extends AbstractCrudCMSTable
{
    protected $columns = [
        'web_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'web'
                ],
                'relation' => [
                    'name' => 'web',
                    'column' => 'title',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'html_wrap_open' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'html_wrap_open'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'html_wrap_close' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'html_wrap_close'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-right',
                    ],
                ],
            ],
        ],
    ];
}
