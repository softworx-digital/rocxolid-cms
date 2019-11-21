<?php

namespace Softworx\RocXolid\CMS\Models\Forms\ShoppingCart;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
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
        // $fields['web_id']['options']['show-null-option'] = true;
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        foreach (['continue_shopping', 'checkout'] as $param)
        {
            // $fields[sprintf('%s_page_id', $param)]['options']['show-null-option'] = true;
            $fields[sprintf('%s_page_id', $param)]['options']['collection']['filters'][] = [
                'class' => BelongsToWeb::class,
                'data' => $this->getModel()->detectWeb($this),
            ];
        }

        return $fields;
    }
}