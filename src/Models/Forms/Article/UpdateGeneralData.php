<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

use Illuminate\Validation\Rule;
// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Article model general data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateGeneralData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields = collect($fields)->only($this->getModel()->getModelViewerComponent()->panelData('data.general'))->toArray();

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
