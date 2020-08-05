<?php

namespace Softworx\RocXolid\CMS\Models\DataDependencies;

use Carbon\Carbon;
use Illuminate\Support\Collection;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid cms contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DataDependencies\AbstractDataDependencyDecorator;

/**
 * Decorator for DATE typed custom data dependencies.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class DateDecorator extends AbstractDataDependencyDecorator
{
    /**
     * {@inheritDoc}
     */
    public function provideDependencyFieldDefinition(AbstractCrudForm $form, ElementableDependencyDataProvider $dependency_data_provider): array
    {
        switch ($this->elementable_dependency->default_value_date) {
            case 'today':
                $value = date('Y-m-d');
                break;
            default:
                $value = null;
        }

        return [
            $this->getAssignmentDefaultName() => [
                'type' => FieldType\Datepicker::class,
                'options' => [
                    'label' => [
                        'title-translated' => $this->elementable_dependency->getTitle(),
                        'hint-translated' => $this->elementable_dependency->description,
                    ],
                    'value' => $value,
                    'validation' => [
                        'rules' => [
                            $this->elementable_dependency->is_required ? 'required' : 'nullable',
                            'date',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getDataProviderFieldValue(ElementableDependencyDataProvider $dependency_data_provider, Collection $data, string $field_name): string
    {
        return $data->get($field_name) ? Carbon::make($data->get($field_name))->locale(app()->getLocale())->isoFormat('l') : '';
    }
}