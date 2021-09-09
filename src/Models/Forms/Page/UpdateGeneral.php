<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Page;

use Illuminate\Validation\Rule;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms facades
use Softworx\RocXolid\CMS\Facades\ThemeManager;

/**
 * General data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateGeneral extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'general-data',
    ];

    protected $fields = [
        'web_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
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
        'is_web_localization_homepage' => [
            'type' => FieldType\CheckboxToggle::class,
            'options' => [
                'label' => [
                    'title' => 'is_web_localization_homepage',
                ],
            ],
        ],
        'path' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'path',
                ],
                // 'prefix' => '/',
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
    ];

    /**
     * {@inheritDoc}
     *//*
    protected function adjustFieldsDefinition($fields)
    {
        return collect($fields)->only($this->getModel()->getGeneralDataAttributes(true))->toArray();
    }*/

    protected function adjustFieldsDefinition($fields)
    {
        $web = Web::find($this->getInputFieldValue('web_id')) ?? $this->getModel()->web;
        $localization = Localization::find($this->getInputFieldValue('localization_id')) ?? $this->getModel()->localization;
        $is_homepage = (bool)($this->getInputFieldValue('is_web_localization_homepage') ?? $this->getModel()->isHomePage());

        $fields['web_id']['options']['collection'] = Web::all()->pluck('name', 'id');
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        !$web ?: $fields['localization_id']['options']['collection'] = $web->localizations->pluck('name', 'id');
        $fields['localization_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['is_web_localization_homepage']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'is_web_localization_homepage')->where(function ($query) {
            return $query
                ->where('web_id', $this->getInputFieldValue('web_id'))
                ->where('localization_id', $this->getInputFieldValue('localization_id'))
                ->where('is_web_localization_homepage', true)
                ->where($this->getModel()->getKeyName(), '!=', $this->getModel()->getKey());
        });
        $fields['is_web_localization_homepage']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        !$web || !$localization ?: $fields['path']['options']['prefix'] = $web->localizeUrl($localization) . ($is_homepage ? '' : '/');

        if ($is_homepage) {
            $fields['path']['options']['validation']['rules'] = array_diff($fields['path']['options']['validation']['rules'], [ 'required' ]);
            $fields['path']['options']['disabled'] = true;
            $fields['path']['options']['force-value'] = '';
        }
        //
        $fields['theme']['options']['choices'] = ThemeManager::getThemes();

        return $fields;
    }
}
