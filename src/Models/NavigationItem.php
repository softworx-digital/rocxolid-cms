<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Contracts\Container;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits\IsContained;
use Softworx\RocXolid\Models\Traits\CanContain;
//
use Softworx\RocXolid\Common\Models\Traits\HasImage;
//
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\Traits\HasProxyPageLink;

/**
 *
 */
class NavigationItem extends AbstractPageElement implements Containee, Container
{
    use IsContained;
    use CanContain;
    use HasImage;
    use HasProxyPageLink;

    protected $table = 'cms_page_element_containee_navigation_item';

    protected $fillable = [
        'web_id',
        'url',
        'page_id',
        'page_proxy_id',
        'page_proxy_model_id',
        'name',
        'subtitle',
        'css_class',
        'text',
        'button',
    ];

    protected $relationships = [
        'web',
        'page',
        'pageProxy',
    ];

    protected $containment_ownership = [
        'items' => true,
    ];

    protected $image_sizes = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '330x160' => [ 'width' => 330, 'height' => 160, 'method' => 'fit', 'constraints' => [ ], ],
            '630x160' => [ 'width' => 630, 'height' => 160, 'method' => 'fit', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '592x350' => [ 'width' => 592, 'height' => 350, 'method' => 'fit', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '500x500' => [ 'width' => 500, 'height' => 500, 'method' => 'fit', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->web()->associate($this->getContainerElement($data)->web);

        return parent::onCreateBeforeSave($data);
    }

    /**
     * {@inheritDoc}
     */
    public function onUpdateAfterSave(Collection $data): Crudable
    {
        if (!$this->hasContainer('items')) {
            $this->getContainerElement($data)->attachContainee('items', $this);
        }

        return parent::onUpdateAfterSave($data);
    }

    public function getContainerElement(Collection $data)
    {
        if ($this->hasContainer('items')) {
            return $this->getContainer('items');
        } else {
            $container_class = $data->get('container_type');

            return $container_class::findOrFail($data->get('container_id'));
        }
    }
}
