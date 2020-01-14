<?php

namespace Softworx\RocXolid\CMS\Models\Forms\CookieConsent;

use Softworx\RocXolid\CMS\Models\Forms\AbstractUpdateInPageElementable;
// fields
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;

/**
 *
 */
class UpdateInPageElementable extends AbstractUpdateInPageElementable
{
    protected function adjustFieldsDefinition($fields)
    {
        $fields['modal_body']['type'] = WysiwygTextarea::class;

        return parent::adjustFieldsDefinition($fields);
    }
}
