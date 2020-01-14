<?php

namespace Softworx\RocXolid\CMS\Models\Forms\ArticleList;

use Illuminate\Support\Collection;
// rocXolid fundamentals
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid fields
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\Switchery;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\Textarea;
use Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
// CMS forms
use Softworx\RocXolid\CMS\Models\Forms\AbstractCreateInPageElementable;

/**
 *
 */
class CreateInPageElementable extends AbstractCreateInPageElementable
{
    protected function adjustFieldsDefinition($fields)
    {
        $fields['container_fill_type']['type'] = Select::class;
        $fields['container_fill_type']['options']['placeholder']['title'] = 'container_fill_type';
        $fields['container_fill_type']['options']['choices'] = [
            'auto' => __('rocXolid::cms-article-list.choices.container_fill_type.auto'),
            'manual' => __('rocXolid::cms-article-list.choices.container_fill_type.manual'),
        ];
        $fields['container_fill_type']['options']['validation']['rules'][] = 'required';
        $fields['container_fill_type']['options']['validation']['rules'][] = 'in:auto,manual';
        //$fields['container_fill_type']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $containee_class = $this->getController()->getContaineeClass();

        $containee_model_viewer_component = (new $containee_class())->getModelViewerComponent();

        $collection = new Collection();

        foreach ($containee_class::$list_sortable_attributes as $attribute) {
            $collection->put($attribute, $containee_model_viewer_component->translate(sprintf('field.%s', $attribute)));
        }

        $fields['container_auto_order_by_attribute']['type'] = CollectionSelect::class;
        $fields['container_auto_order_by_attribute']['options']['collection'] = $collection;
        // $fields['container_auto_order_by_attribute']['options']['show_null_option'] = true;
        $fields['container_auto_order_by_attribute']['options']['validation']['rules'][] = 'required_if:_data.container_fill_type,auto';
        //
        $fields['container_auto_order_by_direction']['type'] = Select::class;
        $fields['container_auto_order_by_direction']['options']['placeholder']['title'] = 'container_auto_order_by_direction';
        $fields['container_auto_order_by_direction']['options']['choices'] = [
            'asc' => __('rocXolid::cms-article-list.choices.container_auto_order_by_direction.asc'),
            'desc' => __('rocXolid::cms-article-list.choices.container_auto_order_by_direction.desc'),
        ];
        $fields['container_auto_order_by_direction']['options']['validation']['rules'][] = 'required_if:_data.container_fill_type,auto';
        $fields['container_auto_order_by_direction']['options']['validation']['rules'][] = 'in:asc,desc';
        //
        $fields['text']['type'] = WysiwygTextarea::class;

        return parent::adjustFieldsDefinition($fields);
    }
}
