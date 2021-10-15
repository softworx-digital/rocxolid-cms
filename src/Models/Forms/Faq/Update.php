<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Faq;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;

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

    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');

        $fields['answer']['type'] = WysiwygTextarea::class;

        return $fields;
    }
}
