<?php

namespace Softworx\RocXolid\CMS\Models;

use App;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasImages;
// cms models
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
// components
use Softworx\RocXolid\CMS\Components\ModelViewers\GalleryPageElementViewer;

/**
 * Gallery page element model definition.
 *
 * @package  CMS
 * @author   Peter Bolemant <peter@softworx.digital>
 * @version  1.0
 * @access   public
 */
class Gallery extends AbstractPageElement
{
    use HasImages;

    protected $table = 'cms_page_element_gallery';

    protected $fillable = [
        'web_id',
        'name',
    ];

    public function getModelViewerComponent()
    {
        $controller = App::make($this->getControllerClass());

        return GalleryPageElementViewer::build($controller, $controller)->setModel($this)->setController($controller);
    }
}
