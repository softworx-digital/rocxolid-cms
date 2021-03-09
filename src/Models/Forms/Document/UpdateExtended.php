<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Document;

// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid contracts
use Softworx\RocXolid\Triggers\Contracts\Trigger;
// rocXolid trigger rules
use Softworx\RocXolid\Triggers\Rules\PassesTriggerValidation;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DataDependency;
// rocXolid cms contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
// rocXolid cms form fields
use Softworx\RocXolid\CMS\Forms\Fields\Type\DependencySelection;
// rocXolid cms elementable dependency rules
use Softworx\RocXolid\CMS\ElementableDependencies\Rules\PassesDependenciesValidation;

/**
 * Extended data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateExtended extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'extended-data',
    ];

    protected $fieldgroups = [
        FieldType\FormFieldGroupAddable::DEFAULT_NAME => [
            'type' => FieldType\FormFieldGroupAddable::class,
            'options' => [
                'wrapper' => [
                    'legend' => [
                        'title' => 'dependencies',
                    ],
                ],
            ]
        ],
        'triggers' => [
            'type' => FieldType\FormFieldGroupAddable::class,
            'options' => [
                'wrapper' => [
                    'legend' => [
                        'title' => 'triggers',
                    ],
                ],
            ]
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [
        'dependencies' => [
            'type' => DependencySelection::class,
            'options' => [
                'label' => [
                    'title' => '_dependencies.title',
                    'hint' => '_dependencies.hint',
                ],
            ],
        ],
        'triggers' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'array' => true,
                'group' => 'triggers',
                'label' => [
                    'title' => '_triggers.title',
                    'hint' => '_triggers.hint',
                ],
                'placeholder' => [
                    'title' => 'select',
                ],
                'attributes' => [
                    'col' => 'col-xs-12',
                    'class' => 'form-control width-100',
                ],
                'validation' => [
                    'rules' => [
                        'distinct',
                    ],
                ],
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $fields['dependencies']['options']['collection'] = $this->getModel()->getAvailableDependencies()->map(function (ElementableDependency $dependency) {
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
        $fields['dependencies']['options']['validation']['rules'][] = new PassesDependenciesValidation($this);
        //
        $fields['triggers']['options']['collection'] = $this->getModel()->getAvailableTriggers()->map(function (Trigger $trigger) {
            return [
                (new \ReflectionClass($trigger))->getName(),
                $trigger->getTranslatedTitle($this->getController()),
            ];
        })->toAssoc();
        $fields['triggers']['options']['validation']['rules'][] = new PassesTriggerValidation($this);

        return $fields;
    }
}
