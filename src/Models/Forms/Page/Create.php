<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Page;

use Illuminate\Validation\Rule;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
use Softworx\RocXolid\Common\Filters\BelongsToLocalization;
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
        $fields['web_id']['options']['show-null-option'] = true;
        $fields['web_id']['options']['validation']['rules'][] = 'required';
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['localization_id']['options']['show-null-option'] = true;
        $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');
        $fields['localization_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['page_template_id']['options']['show-null-option'] = true;
        $fields['page_template_id']['options']['collection']['filters'][] = [
            'class' => BelongsToWeb::class,
            'data' => $this->getModel()->detectWeb($this),
        ];
        $fields['page_template_id']['options']['collection']['filters'][] = [
            'class' => BelongsToLocalization::class,
            'data' => $this->getModel()->detectLocalization($this),
        ];
        //
        $fields['seo_url_slug']['options']['validation']['rules'][] = 'required';
        $fields['seo_url_slug']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'seo_url_slug')->where(function ($query)
        {
            $query
                ->where('web_id', $this->getFormField('web_id')->getValue())
                ->where('localization_id', $this->getFormField('localization_id')->getValue());
        });

        return $fields;
    }
}