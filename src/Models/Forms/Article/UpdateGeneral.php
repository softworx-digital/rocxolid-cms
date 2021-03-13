<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

use Illuminate\Validation\Rule;
// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * General data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateGeneral extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'general-data',
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $fields = collect($fields)->only($this->getModel()->getGeneralDataAttributes(true))->toArray();

        $fields['title']['options']['validation']['rules'] = Rule::unique('cms_articles', 'title')->ignore($this->getModel()->getKey());

        return $fields;
    }
}
