<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Page;

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
use Softworx\RocXolid\CMS\Models\DataDependency;
// rocXolid cms elementable dependency rules
use Softworx\RocXolid\CMS\ElementableDependencies\Rules\PassesDependenciesValidation;
// filters
// use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// use Softworx\RocXolid\Common\Filters\BelongsToLocalization;

/**
 *
 */
class Create extends RocXolidAbstractCrudForm
{
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
        'dependency' => [
            'type' => FieldType\FormFieldGroup::class,
            'options' => [
                'wrapper' => [
                    'legend' => [
                        'title' => 'dependencies',
                    ],
                ],
            ]
        ],
    ];

    protected $fields = [
        'web_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'web_id',
                ],
                'attributes' => [
                    'placeholder' => 'select',
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
                'attributes' => [
                    'placeholder' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'name' => [
            'type' => FieldType\Input::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:100',
                    ],
                ],
            ],
        ],
        'path' => [
            'type' => FieldType\Input::class,
            'options' => [
                'group' => 'base',
                'label' => [
                    'title' => 'path',
                ],
                'prefix' => '/',
                'validation' => [
                    'rules' => [
                        'required',
                        'regex:/^[a-z0-9_\.\-]\/?([a-z0-9_\.\/\-]*)$/',
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
                'attributes' => [
                    'placeholder' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
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
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'group' => 'dependency',
                'label' => [
                    'title' => 'dependencies',
                ],
                'attributes' => [
                    'placeholder' => 'select',
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
        $fields['dependencies']['options']['collection'] = $this->getModel()->getAvailableDependencies()->mapWithKeys(function ($dependency) {
            return [ (new \ReflectionClass($dependency))->getName() => $dependency->getTranslatedTitle($this->getController()) ];
        });
        // $fields['dependencies']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        // $fields['dependencies']['options']['validation']['rules'][] = new PassesDependenciesValidation($this);

        return $fields;
    }
}
