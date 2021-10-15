<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Article model meta data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateMetaData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields = collect($fields)->only($this->getModel()->getModelViewerComponent()->panelData('data.meta'))->toArray();

        return $fields;
    }
}
