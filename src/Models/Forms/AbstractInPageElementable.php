<?php

namespace Softworx\RocXolid\CMS\Models\Forms;

use Illuminate\Support\Str;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// field types
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
use Softworx\RocXolid\Common\Filters\BelongsToLocalization;

/**
 *
 */
abstract class AbstractInPageElementable extends RocXolidAbstractCrudForm
{
    protected function adjustFieldsDefinition($fields)
    {
        $page_elementable = $this->getController()->getPageElementable($this->getRequest());

        $this
            ->adjustUrlFields($page_elementable, $fields)
            ->adjustPageFields($page_elementable, $fields)
            ->adjustPageProxyFields($page_elementable, $fields)
            //->adjustWysiwygFields($page_elementable, $fields)
            ->setWebField($page_elementable, $fields)
            ->setPageElementableField($page_elementable, $fields);

        return $fields;
    }

    protected function adjustUrlFields($page_elementable, &$fields)
    {
        foreach ($fields as $field_name => &$field_definition) {
            if (substr($field_name, -3) == 'url') {
                $param = substr($field_name, 0, -3);
                //
                $field_definition['options']['validation']['rules'] = sprintf('sometimes|nullable|only_one:_data.%surl,_data.%spage_id,_data.%spage_proxy_id', $param, $param, $param);
            }
        }

        return $this;
    }

    protected function adjustPageFields($page_elementable, &$fields)
    {
        foreach ($fields as $field_name => &$field_definition) {
            if (substr($field_name, -7) == 'page_id') {
                $param = substr($field_name, 0, -7);
                //
                $field_definition['options']['validation']['rules'] = sprintf('sometimes|nullable|only_one:_data.%surl,_data.%spage_id,_data.%spage_proxy_id', $param, $param, $param);
                $field_definition['options']['collection']['filters'] = [
                    [
                        'class' => BelongsToWeb::class,
                        'data' => $page_elementable->web,
                    ],
                ];
                $field_definition['options']['collection']['filters'] = [
                    [
                        'class' => BelongsToLocalization::class,
                        'data' => $page_elementable->localization,
                    ],
                ];
            }
        }

        return $this;
    }

    protected function adjustPageProxyFields($page_elementable, &$fields)
    {
        foreach ($fields as $field_name => &$field_definition) {
            if (substr($field_name, -13) == 'page_proxy_id') {
                $param = substr($field_name, 0, -13);
                //
                $field_definition['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel(), [ '_section' => $this->getOption('component.section', null) ]);
                $field_definition['options']['validation']['rules'] = sprintf('sometimes|nullable|only_one:_data.%surl,_data.%spage_id,_data.%spage_proxy_id', $param, $param, $param);
                $field_definition['options']['collection']['filters'] = [
                    [
                        'class' => BelongsToWeb::class,
                        'data' => $page_elementable->web,
                    ],
                ];
                $field_definition['options']['collection']['filters'] = [
                    [
                        'class' => BelongsToLocalization::class,
                        'data' => $page_elementable->localization,
                    ],
                ];

                if ($field_name == 'containee_page_proxy_id') { // hot"fix"
                    $field_definition['options']['validation']['rules'] = 'required';
                }
                //
                if (method_exists($this->getModel(), 'adjustPageProxyModelFieldDefinition')) {
                    $this->getModel()->adjustPageProxyModelFieldDefinition($this, $fields, $param ? sprintf('%sPageProxy', Str::camel($param)) : 'pageProxy');
                }
            }
        }

        return $this;
    }

    protected function adjustWysiwygFields($page_elementable, &$fields)
    {
        foreach ($fields as $field_name => &$field_definition) {
            if (in_array($field_name, ['subtitle', 'content'])) {
                $field_definition['type'] = WysiwygTextarea::class;
            }
        }

        return $this;
    }

    protected function setWebField($page_elementable, &$fields)
    {
        unset($fields['web_id']);
        /*
        $fields['web_id']['type'] = Hidden::class;
        $fields['web_id']['options'] = [];
        $fields['web_id']['options']['value'] = $page_elementable->web->getKey();
        $fields['web_id']['options']['validation']['rules'][] = 'required';
        */

        return $this;
    }

    protected function setPageElementableField($page_elementable, &$fields)
    {
        $page_elementable_field_param = $page_elementable->getRequestFieldParam();

        $fields[$page_elementable_field_param]['type'] = Hidden::class;
        $fields[$page_elementable_field_param]['options']['value'] = $page_elementable->getKey();
        $fields[$page_elementable_field_param]['options']['validation']['rules'][] = 'required';

        return $this;
    }
}
