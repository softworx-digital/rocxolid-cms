<?php

namespace Softworx\RocXolid\CMS\Models\Forms\NavigationItem;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// field types
use Softworx\RocXolid\Forms\Fields\Type\Input,
    Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea,
    Softworx\RocXolid\Forms\Fields\Type\CollectionSelect,
    Softworx\RocXolid\Forms\Fields\Type\UploadImage;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// commerce models
use Softworx\RocXolid\Commerce\Models\ProductCategory;
// cms models
use Softworx\RocXolid\CMS\Models\Page,
    Softworx\RocXolid\CMS\Models\PageProxy;
/**
 *
 */
class UpdateInRowNavigation extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'row-navigation-items',
    ];

    protected $fields_order = [
        'image',
    ];

    protected $fields = [
        /*
        'product_category_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => ProductCategory::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'product_category',
                ],
                'show_null_option' => true,
                'validation' => [
                    'rules' => 'sometimes|nullable',
                ],
            ],
        ],
        */
        'name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'subtitle' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'subtitle',
                ],
            ],
        ],
        'css_class' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'css_class',
                ],
            ],
        ],
        'text' => [
            'type' => WysiwygTextarea::class,
            'options' => [
                'label' => [
                    'title' => 'text',
                ],
                'validation' => [
                    'rules' => [
                        //'required',
                    ],
                ],
            ],
        ],
        'button' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'button',
                ],
                'validation' => [
                    'rules' => [
                        //'required',
                    ],
                ],
            ],
        ],
        'url' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'url',
                ],
                'validation' => [
                    'rules' => 'sometimes|nullable|only_one:_data.url,_data.page_id,_data.page_proxy_id',
                ],
            ],
        ],
        'page_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Page::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'page',
                ],
                // 'show_null_option' => true,
                'validation' => [
                    'rules' => 'sometimes|nullable|only_one:_data.url,_data.page_id,_data.page_proxy_id',
                ],
            ],
        ],
        'page_proxy_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => PageProxy::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'page_proxy',
                ],
                // 'show_null_option' => true,
                'validation' => [
                    'rules' => 'sometimes|nullable|only_one:_data.url,_data.page_id,_data.page_proxy_id',
                ],
            ],
        ],
    ];

    // @todo zjednotit asi do parent classy s UpdateInMainNavigation
    protected function adjustFieldsDefinition($fields)
    {
        $fields['image']['type'] = UploadImage::class;
        $fields['image']['options']['multiple'] = false;
        $fields['image']['options']['label']['title'] = 'image';
        //
        /*
        $fields['product_category_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $this->getModel()->web,
        ];
        */
        //
        $fields['page_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $this->getModel()->web,
        ];
        //
        $fields['page_proxy_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel(), [ '_section' => $this->getOption('component.section', null) ]);
        $fields['page_proxy_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $this->getModel()->web,
        ];
        //
        $this->getModel()->adjustPageProxyModelFieldDefinition($this, $fields);

        return $fields;
    }
}