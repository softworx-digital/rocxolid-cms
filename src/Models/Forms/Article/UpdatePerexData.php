<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Article model perec data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdatePerexData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields = collect($fields)->only($this->getModel()->getModelViewerComponent()->panelData('data.perex'))->toArray();

        $fields['perex']['type'] = FieldType\WysiwygTextarea::class;

        return $fields;
    }
}
