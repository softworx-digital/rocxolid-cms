<?php

namespace Softworx\RocXolid\CMS\Models\Forms\WebFrontpageSettings;

// rocXolid fundamentals
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// contracts
use Softworx\RocXolid\Forms\Contracts\FormField;
// fields
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
use Softworx\RocXolid\Forms\Fields\Type\UploadFile;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;

/**
 *
 */
class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['template_set']['type'] = Select::class;
        $fields['template_set']['options']['placeholder']['title'] = 'template_set';
        $fields['template_set']['options']['choices'] = $this->getModel()->getTemplateSetsOptions();

        $fields['logo']['type'] = UploadImage::class;
        $fields['logo']['options']['multiple'] = false;
        $fields['logo']['options']['label']['title'] = 'logo';

        $fields['logoInverted']['type'] = UploadImage::class;
        $fields['logoInverted']['options']['multiple'] = false;
        $fields['logoInverted']['options']['label']['title'] = 'logo-mobile';

        $fields['favicon']['type'] = UploadImage::class;
        $fields['favicon']['options']['multiple'] = false;
        $fields['favicon']['options']['label']['title'] = 'favicon';
        $fields['favicon']['options']['image-preview-size'] = '144x144';

        $fields['cssFiles']['type'] = UploadFile::class;
        $fields['cssFiles']['options']['multiple'] = true;
        $fields['cssFiles']['options']['label']['title'] = 'cssFiles';

        $fields['jsFiles']['type'] = UploadFile::class;
        $fields['jsFiles']['options']['multiple'] = true;
        $fields['jsFiles']['options']['label']['title'] = 'jsFiles';

        return $fields;
    }
}
