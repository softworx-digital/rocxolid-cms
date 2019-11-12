<?php

namespace Softworx\RocXolid\CMS\Models;

use App;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasImage;
use Softworx\RocXolid\Common\Models\Traits\HasFile;
// cms models
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
// components
use Softworx\RocXolid\CMS\Components\ModelViewers\TextPageElementViewer;

/**
 * Text page element model definition.
 *
 * @package  CMS
 * @author   Peter Bolemant <peter@softworx.digital>
 * @version  1.0
 * @access   public
 */
class Text extends AbstractPageElement
{
    use HasImage;
    use HasFile;

    protected $table = 'cms_page_element_text';

    protected $fillable = [
        'web_id',
        'name',
        'content',
    ];

    protected $image_dimensions = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '1920x240' => [ 'width' => 1920, 'height' => 240, 'method' => 'fit', 'constraints' => [ ], ],
            '1920x700' => [ 'width' => 1920, 'height' => 700, 'method' => 'fit', 'constraints' => [ ], ],
        ],
    ];

    public function getModelViewerComponent()
    {
        return (new TextPageElementViewer())->setModel($this)->setController(App::make($this->getControllerClass()));
    }
}