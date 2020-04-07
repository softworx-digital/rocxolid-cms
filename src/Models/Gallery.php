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
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class Gallery extends AbstractPageElement
{
    use HasImages;

    protected $table = 'cms_page_element_gallery';

    protected $fillable = [
        'web_id',
        'name',
    ];

    public function getModelViewerComponent(?string $view_package = null)
    {
        $controller = $this->getCrudController();

        $model_viewer = GalleryPageElementViewer::build($controller, $controller)->setModel($this)->setController($controller);

        if (!is_null($view_package)) {
            $model_viewer->setViewPackage($view_package);
        }

        return $model_viewer;
    }
}
