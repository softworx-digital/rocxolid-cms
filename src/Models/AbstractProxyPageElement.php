<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
//
use Softworx\RocXolid\Contracts\Modellable;
use Softworx\RocXolid\Traits\Modellable as ModellableTrait;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\CMS\Models\Contracts\PageProxyElement;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\PageProxy;

abstract class AbstractProxyPageElement extends AbstractPageElement implements PageProxyElement, Modellable
{
    use ModellableTrait;

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        if ($data->has('_page_proxy_id')) {
            $page_elementable = PageProxy::findOrFail($data->get('_page_proxy_id'));
        }

        if (!isset($page_elementable)) {
            throw new \InvalidArgumentException(sprintf('Undefined _page_template_id or _page_proxy_id or _page_id or _article_id'));
        }

        $this->web()->associate($page_elementable->web);

        return parent::onCreateBeforeSave($data);
    }
}
