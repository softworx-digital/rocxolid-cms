<?php

namespace Softworx\RocXolid\CMS\Models\Forms\SliderItem;

// fields
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\Switchery;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;
use Softworx\RocXolid\Forms\Fields\Type\Colorpicker;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;
use Softworx\RocXolid\Common\Filters\BelongsToWeb;

/**
 *
 */
class UpdateInMainSlider extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'main-slider-items',
    ];

    protected $fields = [
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
        $fields['image']['type'] = UploadImage::class;
        $fields['image']['options']['multiple'] = false;
        $fields['image']['options']['label']['title'] = 'image';
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
        //
        $fields['template']['type'] = Select::class;
        $fields['template']['options']['choices'] = $this->getModel()->getTemplateOptions();
        $fields['template']['options']['validation']['rules'][] = 'required';

        return $fields;
    }
}
