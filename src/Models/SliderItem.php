<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
//
use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Traits\IsContained;
use Softworx\RocXolid\Common\Models\Traits\HasImage;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Components\ModelViewers\SliderItemViewer;
// cms traits
use Softworx\RocXolid\CMS\Models\Traits\HasProxyPageLink;

/**
 *
 */
class SliderItem extends AbstractPageElement implements Containee
{
    use IsContained;
    use HasImage;
    use HasProxyPageLink;

    protected $table = 'cms_page_element_containee_slider_item';

    protected $fillable = [
        'web_id',
        'url',
        'page_id',
        'page_proxy_id',
        'page_proxy_model_id',
        'name',
        'text',
        'button',
        'is_right',
        'background_color',
        'name_color',
        'text_color',
        'template',
    ];

    protected $relationships = [
        'web',
        'page',
        'pageProxy',
    ];

    protected $image_sizes = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 124, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '768x457' => [ 'width' => 768, 'height' => 372, 'method' => 'fit', 'constraints' => [ ], ],
            '1280x500' => [ 'width' => 1280, 'height' => 620, 'method' => 'fit', 'constraints' => [ ], ],
            '1920x960' => [ 'width' => 1920, 'height' => 960, 'method' => 'fit', 'constraints' => [ ], ],
        ],
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getModelViewerComponent()
    {
        $controller = $this->getCrudController();

        return SliderItemViewer::build($controller, $controller)->setModel($this)->setController($controller);
    }

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->web()->associate($this->getContainerElement($data)->web);

        return parent::onCreateBeforeSave($data);
    }

    public function afterSave($data, $action = null)
    {
        if (!$this->hasContainer('items')) {
            $this->getContainerElement($data)->attachContainee('items', $this);
        }

        return $this;
    }

    public function getContainerElement($data)
    {
        if ($this->hasContainer('items')) {
            return $this->getContainer('items');
        } else {
            $container_class = $data['container_type'];

            return $container_class::findOrFail($data['container_id']);
        }
    }
}
