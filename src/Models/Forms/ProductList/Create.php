<?php

namespace Softworx\RocXolid\CMS\Models\Forms\ProductList;

use Illuminate\Support\Collection;
// rocXolid fundamentals
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid fields
use Softworx\RocXolid\Forms\Fields\Type\Input,
    Softworx\RocXolid\Forms\Fields\Type\Email,
    Softworx\RocXolid\Forms\Fields\Type\Switchery,
    Softworx\RocXolid\Forms\Fields\Type\Select,
    Softworx\RocXolid\Forms\Fields\Type\CollectionSelect,
    Softworx\RocXolid\Forms\Fields\Type\Textarea,
    Softworx\RocXolid\Forms\Fields\Type\ButtonGroup,
    Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit,
    Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
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

    protected function adjustFieldsDefinition($fields)
    {
        $fields['container_fill_type']['type'] = Select::class;
        $fields['container_fill_type']['options']['placeholder']['title'] = 'container_fill_type';
        $fields['container_fill_type']['options']['choices'] = [
            'auto' => __('rocXolid::cms-product-list.choices.container_fill_type.auto'),
            'manual' => __('rocXolid::cms-product-list.choices.container_fill_type.manual'),
        ];
        $fields['container_fill_type']['options']['validation']['rules'][] = 'required';
        $fields['container_fill_type']['options']['validation']['rules'][] = 'in:auto,manual';
        //$fields['container_fill_type']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $containee_class = $this->getController()->getContaineeClass();

        $containee_model_viewer_component = (new $containee_class())->getModelViewerComponent();

        $collection = new Collection();

        foreach ($containee_class::$list_sortable_attributes as $attribute)
        {
            $collection->put($attribute, $containee_model_viewer_component->translate(sprintf('field.%s', $attribute)));
        }

        $fields['container_auto_order_by_attribute']['type'] = CollectionSelect::class;
        $fields['container_auto_order_by_attribute']['options']['collection'] = $collection;
        $fields['container_auto_order_by_attribute']['options']['show_null_option'] = true;
        $fields['container_auto_order_by_attribute']['options']['validation']['rules'][] = 'required_if:_data.container_fill_type,auto';
        //
        $fields['container_auto_order_by_direction']['type'] = Select::class;
        $fields['container_auto_order_by_direction']['options']['placeholder']['title'] = 'container_auto_order_by_direction';
        $fields['container_auto_order_by_direction']['options']['choices'] = [
            'asc' => __('rocXolid::cms-product-list.choices.container_auto_order_by_direction.asc'),
            'desc' => __('rocXolid::cms-product-list.choices.container_auto_order_by_direction.desc'),
        ];
        $fields['container_auto_order_by_direction']['options']['validation']['rules'][] = 'required_if:_data.container_fill_type,auto';
        $fields['container_auto_order_by_direction']['options']['validation']['rules'][] = 'in:asc,desc';
        //
        $fields['text']['type'] = WysiwygTextarea::class;

        return parent::adjustFieldsDefinition($fields);
    }
}