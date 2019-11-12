<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

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
        'image',
        'web_id',
        'localization_id',
        'date',
        'name',
        //'seo_url_slug',
        'openGraphImage',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'perex',
        //'css_class',
        'is_enabled'
    ];

    protected function adjustFieldsDefinition($fields)
    {

        $fields['image']['type'] = UploadImage::class;
        $fields['image']['options']['multiple'] = false;
        $fields['image']['options']['label']['title'] = 'image';
        $fields['image']['options']['upload-url'] = $this->getController()->getRoute('imageUpload', $this->getModel());
        //
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');
        //
        if (isset($fields['page_template_id']))
        {
            unset($fields['page_template_id']);
        }
        //
        /*
        $fields['seo_url_slug']['options']['validation']['rules'][] = 'required';
        $fields['seo_url_slug']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'seo_url_slug')->where(function ($query)
        {
            $query
                ->where('web_id', $this->getFormField('web_id')->getValue())
                ->where('localization_id', $this->getFormField('localization_id')->getValue());
        })->ignore($this->getModel()->id);
        */
        //
        $fields['openGraphImage']['type'] = UploadImage::class;
        $fields['openGraphImage']['options']['multiple'] = false;
        $fields['openGraphImage']['options']['label']['title'] = 'openGraphImage';

        return $fields;
    }
}