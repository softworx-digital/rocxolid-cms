<?php

namespace Softworx\RocXolid\CMS\Models\Forms\PageProxy;

use Illuminate\Validation\Rule;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type\StaticField;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;

/**
 *
 */
class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');
        //
        if (isset($fields['page_template_id'])) {
            unset($fields['page_template_id']);
        }
        //
        $fields['seo_url_slug']['options']['validation']['rules'][] = 'required';
        $fields['seo_url_slug']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'seo_url_slug')->where(function ($query) {
            $query
                ->where('web_id', $this->getFormField('web_id')->getValue())
                ->where('localization_id', $this->getFormField('localization_id')->getValue())
                ->where('model_type', $this->getFormField('model_type')->getValue());
        })->ignore($this->getModel()->getKey());
        //
        //unset($fields['model_type']);
        $fields['model_type']['type'] = CollectionSelect::class;
        $fields['model_type']['options']['placeholder']['title'] = 'model_type';
        $fields['model_type']['options']['collection'] = $this->getModel()->getPageProxyableModels();
        $fields['model_type']['options']['validation']['rules'][] = 'required';
        $fields['model_type']['options']['validation']['rules'][] = 'class_exists';

        return $fields;
    }
}
