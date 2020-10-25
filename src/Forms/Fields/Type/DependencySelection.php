<?php

namespace Softworx\RocXolid\CMS\Forms\Fields\Type;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid form components
use Softworx\RocXolid\Components\Forms\FormField as FormFieldComponent;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\FormFieldGroupAddable;

class DependencySelection extends CollectionSelect
{
    protected $filter_form_field_component;

    protected $default_options = [
        'view-package' => 'rocXolid:cms',
        // 'template' => 'dependency-selection.default',
        'type-template' => 'dependency-selection',
        'array' => true,
        'group' => FormFieldGroupAddable::DEFAULT_NAME,
        // field wrapper
        'wrapper' => false,
        // component helper classes
        'helper-classes' => [
            'error-class' => 'has-error',
            'success-class' => 'has-success',
        ],
        // field label
        'label' => false,
        'placeholder' => [
            'title' => 'select',
        ],
        // field HTML attributes
        'attributes' => [
            'col' => 'col-xs-12',
            'class' => 'form-control width-100',
        ],
        'validation' => [
            'rules' => [
                'distinct',
            ],
        ],
    ];

    public function hasDependencyFieldValuesFilterFields(int $index) {
        $dependency_type_id = $this->getFieldValue($index);

        if (blank($dependency_type_id)) {
            return false;
        }

        list($dependency_type, $dependency_id) = explode(':', sprintf('%s:', $dependency_type_id));

        return blank($dependency_id) && collect(app($dependency_type)->provideDependencyFieldValuesFilterFieldsDefinition($this->getForm()))->isNotEmpty();
    }

    public function getDependencyFieldValuesFilterFieldsComponents(FormFieldComponent $parent_component, int $index): Collection
    {
        $form = $this->getForm();

        $dependency_type_id = $this->getFieldValue($index);

        if (blank($dependency_type_id)) {
            return false;
        }

        list($dependency_type, $dependency_id) = explode(':', sprintf('%s:', $dependency_type_id));

        if (filled($dependency_id)) {
            return collect();
        }

        $dependency = app($dependency_type);

        return collect($dependency->provideDependencyFieldValuesFilterFieldsDefinition($form))
            ->transform(function ($definition, $name) use ($dependency, $form, $parent_component) {
                $form_field = $form->getFormFieldFactory()->makeField($form, $form, $definition['type'], $name, $definition['options']);

                if ($form->wasSubmitted()) {
                    $form_field->setValue(Arr::get($form->getInput(), sprintf('_data.%s', $name)));
                } elseif ($form->getModel()->dependencies_filters->isNotEmpty()) {
                    $param = str_replace(':', '.', Str::after($name, 'filter:'));
                    $form_field->setValue(Arr::get($form->getModel()->dependencies_filters->toArray(), $param));
                }

                return $parent_component->buildInside($parent_component)->setFormField($form_field);
            });
    }
}
