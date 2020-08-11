<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Document;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms form fields
use Softworx\RocXolid\CMS\Forms\Fields\Type\DependencySelection;
// rocXolid cms facades
use Softworx\RocXolid\CMS\Facades\ThemeManager;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DocumentType;
// filters
// use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// use Softworx\RocXolid\Common\Filters\BelongsToLocalization;

/**
 *
 */
class Create extends RocXolidAbstractCrudForm
{
    use Traits\DocumentForm;

    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fieldgroups = [
        'base' => [
            'type' => FieldType\FormFieldGroup::class,
            'options' => [
                'wrapper' => [
                    'legend' => [
                        'title' => 'base',
                    ],
                ],
            ],
        ],
        FieldType\FormFieldGroupAddable::DEFAULT_NAME => [
            'type' => FieldType\FormFieldGroupAddable::class,
            'options' => [
                'wrapper' => [
                    'legend' => [
                        'title' => 'dependencies',
                    ],
                ],
            ]
        ]
    ];

    protected $fields = [/*
        'is_enabled' => [
            'type' => FieldType\CheckboxToggle::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],*/
        'web_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'web_id',
                ],
                'attributes' => [
                    'title' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'localization_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'localization_id',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'document_type_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'document_type_id',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'title' => [
            'type' => FieldType\Input::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'title',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:100',
                    ],
                ],
            ],
        ],
        'theme' => [
            'type' => FieldType\Select::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'theme',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'valid_from' => [
            'type' => FieldType\Datepicker::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'valid_from',
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
                        'date',
                        // 'before:today',
                    ],
                ],
                'attributes' => [
                    'placeholder' => null,
                ],
            ],
        ],
        'valid_to' => [
            'type' => FieldType\Datepicker::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'valid_to',
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
                        'date',
                        // 'before:today',
                    ],
                ],
                'attributes' => [
                    'placeholder' => null,
                ],
            ],
        ],
        'description' => [
            'type' => FieldType\WysiwygTextarea::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'description',
                ],
                'validation' => [
                    'rules' => [
                        'maxplain:10000',
                    ],
                ],
                'attributes' => [
                    'maxlength' => '10000',
                ],
            ],
        ],
        'dependencies' => [
            'type' => DependencySelection::class,
            'options' => [
                'label' => [
                    'title' => '_dependencies.dependency',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        // $fields['web_id']['options']['show-null-option'] = true;
        $fields['web_id']['options']['collection'] = Web::all()->pluck('name', 'id');
        $fields['web_id']['options']['validation']['rules'][] = 'required';
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        // $fields['localization_id']['options']['show-null-option'] = true;
        // $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');
        $fields['localization_id']['options']['collection'] = Localization::all()->pluck('name', 'id');
        $fields['localization_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['theme']['options']['choices'] = ThemeManager::getThemes();
        //
        $fields['document_type_id']['options']['collection'] = DocumentType::all()->pluck('title', 'id');
        //
        $fields['dependencies']['options']['collection'] = $this->getModel()->getAvailableDependencies()->map(function ($dependency) {
            return [
                (new \ReflectionClass($dependency))->getName(),
                $dependency->getTranslatedTitle($this->getController()),
            ];
        })->merge(DataDependency::where([
            'web_id' => $this->getInputFieldValue('web_id') ?? $this->getModel()->web->getKey(),
            'localization_id' => $this->getInputFieldValue('localization_id') ?? $this->getModel()->localization->getKey(),
        ])->get()->map(function ($dependency) {
            return [
                sprintf('%s:%s', DataDependency::class, $dependency->getKey()),
                $dependency->getTitle(),
            ];
        }))->toAssoc();
        $fields['dependencies']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());

        return $fields;
    }
}
