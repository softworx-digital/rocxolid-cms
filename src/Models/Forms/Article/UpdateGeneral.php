<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

use Illuminate\Validation\Rule;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid field types
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
        //
        $fields['web_id']['type'] = FieldType\CollectionSelect::class;
        $fields['web_id']['options']['validation']['rules'][] = 'required';
        //
        $fields['localization_id']['options']['placeholder'] = [
            'title' => 'select'
        ];
        //
        $fields['author_id']['type'] = FieldType\CollectionSelect::class;
        $fields['author_id']['options']['collection'] = $this->getModel()->author()->getRelated()->pluck('name', 'id');
        //
        $fields['article_category_id']['type'] = FieldType\CollectionSelect::class;
        $fields['article_category_id']['options']['placeholder'] = [
            'title' => 'select'
        ];
        $fields['article_category_id']['options']['collection'] = $this->getModel()->articleCategory()->getRelated()->pluck('title', 'id');
        $fields['article_category_id']['options']['validation']['rules'] = [
            'nullable',
            'exists:cms_article_categories,id',
        ];
        //
        $fields['tags']['type'] = FieldType\TagsInput::class;
        //
        $fields['date']['options']['validation']['rules'] = [
            'nullable',
            'date',
        ];

        return $fields;
    }
}
