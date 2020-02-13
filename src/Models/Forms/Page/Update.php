<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Page;

use Illuminate\Validation\Rule;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;

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

    protected $fields_order = [
        'web_id',
        'localization_id',
        'page_template_id',
        'name',
        //'css_class',
        'seo_url_slug',
        //'is_enabled',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'openGraphImage',
        'open_graph_title',
        'open_graph_description',
        'open_graph_type',
        'open_graph_url',
        'open_graph_site_name',
        'description'
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
                ->where('localization_id', $this->getFormField('localization_id')->getValue());
        })->ignore($this->getModel()->getKey());
        //
        $fields['openGraphImage']['type'] = UploadImage::class;
        $fields['openGraphImage']['options']['multiple'] = false;
        $fields['openGraphImage']['options']['label']['title'] = 'openGraphImage';

        return $fields;
    }
}
