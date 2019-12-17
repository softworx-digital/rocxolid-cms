<?php

namespace Softworx\RocXolid\CMS\Models\Forms\NavigationItem;

use Illuminate\Support\Collection;
// rocXolid fundamentals
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// field types
use Softworx\RocXolid\Forms\Fields\Type\Hidden,
    Softworx\RocXolid\Forms\Fields\Type\Input,
    Softworx\RocXolid\Forms\Fields\Type\Email,
    Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit,
    Softworx\RocXolid\Forms\Fields\Type\ButtonGroup,
    Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// commerce models
use Softworx\RocXolid\Commerce\Models\ProductCategory;
// cms models
use Softworx\RocXolid\CMS\Models\MainNavigation,
    Softworx\RocXolid\CMS\Models\Page,
    Softworx\RocXolid\CMS\Models\PageProxy;
/**
 *
 */
class CreateInMainNavigation extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
        'section' => 'main-navigation-items',
    ];

    protected $fields = [
        'container_id' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        //'exists:orders',
                    ],
                ],
            ],
        ],
        'container_type' => [
            'type' => Hidden::class,
            'options' => [
                'value' => MainNavigation::class,
                'validation' => [
                    'rules' => [
                        'required',
                        //'exists:orders',
                    ],
                ],
            ],
        ],/*
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

    // @todo zjednotit asi do parent classy s CreateInRowNavigation
    protected function adjustFieldsDefinition($fields)
    {
        $container = $this->getContainer();

        $fields['container_id']['options']['value'] = $container->id;
        //
        /*
        $fields['product_category_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $container->web,
        ];*/
        //
        $fields['page_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $container->web,
        ];
        //
        $fields['page_proxy_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel(), [ '_section' => $this->getOption('component.section', null) ]);
        $fields['page_proxy_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $container->web,
        ];
        //
        $this->getModel()->adjustPageProxyModelFieldDefinition($this, $fields);

        return $fields;
    }

    protected function getContainer()
    {
        $input = new Collection($this->getRequest()->input());

        if (!$input->has(FormField::SINGLE_DATA_PARAM))
        {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = new Collection($input->get(FormField::SINGLE_DATA_PARAM));

        if (!$container = MainNavigation::find($data->get('container_id')))
        {
            throw new \InvalidArgumentException(sprintf('Invalid container_id [%s]', $data->get('container_id')));
        }

        return $container;
    }
}