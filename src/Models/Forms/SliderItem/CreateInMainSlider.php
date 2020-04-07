<?php

namespace Softworx\RocXolid\CMS\Models\Forms\SliderItem;

// @todo - upratat
use Illuminate\Support\Collection;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
use Softworx\RocXolid\Forms\Fields\Type\Switchery;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\Colorpicker;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;
use Softworx\RocXolid\CMS\Models\MainSlider;
use Softworx\RocXolid\Common\Filters\BelongsToWeb;

class CreateInMainSlider extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
        'section' => 'main-slider-items',
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
                'value' => MainSlider::class,
                'validation' => [
                    'rules' => [
                        'required',
                        //'exists:orders',
                    ],
                ],
            ],
        ],
        'name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'name',
                ],
                'validation' => [
                    'rules' => [
                        //'required',
                    ],
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
        'background_color' => [
            'type' => Colorpicker::class,
            'options' => [
                'label' => [
                    'title' => 'background_color',
                ],
            ],
        ],
        'name_color' => [
            'type' => Colorpicker::class,
            'options' => [
                'label' => [
                    'title' => 'name_color',
                ],
            ],
        ],
        'text_color' => [
            'type' => Colorpicker::class,
            'options' => [
                'label' => [
                    'title' => 'text_color',
                ],
            ],
        ],/*
        'is_right' => [
            'type' => Switchery::class,
            'options' => [
                'label' => [
                    'title' => 'is_right',
                ],
            ],
        ],*/
        'template' => [
            'type' => Select::class,
            'options' => [
                'label' => [
                    'title' => 'template',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $container = $this->getContainer();

        $fields['container_id']['options']['value'] = $container->getKey();
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
        //
        $fields['template']['type'] = Select::class;
        $fields['template']['options']['choices'] = $this->getModel()->getTemplateOptions($container->web);
        $fields['template']['options']['validation']['rules'][] = 'required';

        return $fields;
    }

    protected function getContainer()
    {
        $input = collect($this->getRequest()->input());

        if (!$input->has(FormField::SINGLE_DATA_PARAM)) {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = collect($input->get(FormField::SINGLE_DATA_PARAM));

        if (!$container = MainSlider::find($data->get('container_id'))) {
            throw new \InvalidArgumentException(sprintf('Invalid container_id [%s]', $data->get('container_id')));
        }

        return $container;
    }
}
