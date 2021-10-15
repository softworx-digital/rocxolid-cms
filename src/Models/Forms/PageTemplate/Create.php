<?php

namespace Softworx\RocXolid\CMS\Models\Forms\PageTemplate;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['web_id']['options']['validation']['rules'][] = 'required';
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');

        return $fields;
    }
}
