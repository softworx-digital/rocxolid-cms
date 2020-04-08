<?php

namespace Softworx\RocXolid\CMS\Models\Tables\TopPanel;

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
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'login' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'login'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'login_img_alt' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'login_img_alt'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'logout' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'logout'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'login_panel' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'login_panel'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_email' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_email'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_password' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_password'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_error' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_error'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'form_field_remember_me' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'form_field_remember_me'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'forgot_password' => [
            'type' => PageRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'forgot_password'
                ],
                'relation' => [
                    'name' => 'forgotPasswordPage',
                    'empty' => 'forgotPasswordPage',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'button_login' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'button_login'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'button_register' => [
            'type' => PageRelation::class,
            'options' => [
                'type-template' => 'cms.page',
                'ajax' => true,
                'label' => [
                    'title' => 'button_register'
                ],
                'relation' => [
                    'name' => 'buttonRegisterPage',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'cart' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'cart'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
        'cart_img_alt' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'cart_img_alt'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-left',
                    ],
                ],
            ],
        ],
    ];
}
