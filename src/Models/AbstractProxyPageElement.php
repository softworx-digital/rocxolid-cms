<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\Contracts\Modellable;
use Softworx\RocXolid\Traits\Modellable as ModellableTrait;
use Softworx\RocXolid\CMS\Models\Contracts\PageProxyElement;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\PageProxy;

abstract class AbstractProxyPageElement extends AbstractPageElement implements PageProxyElement, Modellable
{
    use ModellableTrait;

    public function fillCustom($data, $action = null)
    {
        if (!isset($data['web_id'])) {
            if (isset($data['_page_proxy_id'])) {
                $page_elementable = PageProxy::findOrFail($data['_page_proxy_id']);
            }

            if (!isset($page_elementable)) {
                throw new \InvalidArgumentException(sprintf('Undefined _page_proxy_id'));
            }

            $this->web_id = $page_elementable->web->id;
        }

        return $this;
    }
}
