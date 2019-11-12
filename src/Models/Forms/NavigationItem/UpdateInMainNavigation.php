<?php

namespace Softworx\RocXolid\CMS\Models\Forms\NavigationItem;

// rocXolid fundamentals
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// field types
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// commerce models
use Softworx\RocXolid\Commerce\Models\ProductCategory;
// cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;
/**
 *
 */
class UpdateInMainNavigation extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'main-navigation-items',
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
        ],*/
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
        'url' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'url',
                ],
                'validation' => [
                    'rules' => 'sometimes|nullable|url|only_one:_data.url,_data.page_id,_data.page_proxy_id',
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
                'show_null_option' => true,
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
                'show_null_option' => true,
                'validation' => [
                    'rules' => 'sometimes|nullable|only_one:_data.url,_data.page_id,_data.page_proxy_id',
                ],
            ],
        ],
    ];

    // @todo zjednotit asi do parent classy s UpdateInRowNavigation
    protected function adjustFieldsDefinition($fields)
    {
        //
        /*
        $fields['product_category_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $this->getModel()->web,
        ];
        */
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
/*
    public function adjustUpdateBeforeSubmit(CrudRequest $request)
    {
        if (!$this->hasFormField('page_proxy_model_id') && $this->getModel()->detectPageProxy($this)->exists)
        {
            $this->addFormField($this->getModel()->getPageProxyModelField($this, $this->getModel()->detectPageProxy($this)));
        }

        return $this;
    }
*/
}