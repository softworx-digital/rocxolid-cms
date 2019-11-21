<?php

namespace Softworx\RocXolid\CMS\Models\Forms\LoginRegistration;

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
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        //foreach (['login_form_forgot_password', 'after_registration'] as $param)
        foreach ([] as $param)
        {
            $fields[sprintf('%s_url', $param)]['options']['validation']['rules'] = sprintf('sometimes|nullable|only_one:_data.%s_url,_data.%s_page_id,_data.%s_page_proxy_id', $param, $param, $param);
            //
            // $fields[sprintf('%s_page_id', $param)]['options']['show-null-option'] = true;
            $fields[sprintf('%s_page_id', $param)]['options']['validation']['rules'] = sprintf('sometimes|nullable|only_one:_data.%s_url,_data.%s_page_id,_data.%s_page_proxy_id', $param, $param, $param);
            $fields[sprintf('%s_page_id', $param)]['options']['collection']['filters'][] = [
                'class' => BelongsToWeb::class,
                'data' => $this->getModel()->detectWeb($this),
            ];
            //
            $fields[sprintf('%s_page_proxy_id', $param)]['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
            $fields[sprintf('%s_page_proxy_id', $param)]['options']['validation']['rules'] = sprintf('sometimes|nullable|only_one:_data.%s_url,_data.%s_page_id,_data.%s_page_proxy_id', $param, $param, $param);
            $fields[sprintf('%s_page_proxy_id', $param)]['options']['collection']['filters'][] = [
                'class' => BelongsToWeb::class,
                'data' => $this->getModel()->detectWeb($this),
            ];
            //
            $this->getModel()->adjustPageProxyModelFieldDefinition($this, $fields, sprintf('%sPageProxy', camel_case($param)));
        }

        return $fields;
    }
}