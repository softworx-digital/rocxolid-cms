<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Document;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// rocXolid filters
use Softworx\RocXolid\Filters\Closurable;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\CMS\Forms\Fields\Type\ElementablePartSelection;
// models
use Softworx\RocXolid\CMS\Models\DocumentFooter;

/**
 *
 */
class UpdateFooter extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'footer',
        'title-template' => 'title-section',
    ];

    protected $fields = [
        'document_footer_id' => [
            'type' => ElementablePartSelection::class,
            'options' => [
                'part' => 'footer',
                'validation' => [
                    'rules' => [
                        'nullable',
                        // 'required',
                        // 'exists:cms_document_footers,id'
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['document_footer_id']['options']['collection']['model'] = DocumentFooter::class;
        $fields['document_footer_id']['options']['collection']['filters'] = [[
            'class' => Closurable::class,
            'data' => function (Builder $query, Model $model) {
                return $query
                    ->where('is_bound', 0)
                    ->where('web_id', $this->getModel()->web->getKey())
                    ->where('localization_id', $this->getModel()->localization->getKey());
            }
        ]];

        return $fields;
    }
}
