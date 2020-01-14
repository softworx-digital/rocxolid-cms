<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

// @todo - upratat
use App;
use Illuminate\Support\Collection;
use Softworx\RocXolid\Http\Requests\FormRequest;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\CMS\Models\Contracts\PageElementable;
use Softworx\RocXolid\CMS\Models\PageProxy;

// @todo - cele refactornut - vzhladom na pagelementable a pageelementy, ktore mozu mat v sebe elementy (containery)
abstract class AbstractPageElementProxyController extends AbstractPageElementController
{
    // @todo - zrejme posielat aj classu + test na interface po find instancie a neifovat to - skarede
    public function getPageElementable(FormRequest $request): PageElementable
    {
        if (!$request->has(FormField::SINGLE_DATA_PARAM)) {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = new Collection($request->get(FormField::SINGLE_DATA_PARAM));

        if ($data->has('_page_proxy_id')) {
            $page_elementable = PageProxy::findOrFail($data->get('_page_proxy_id'));
        }

        if (!isset($page_elementable)) {
            throw new \InvalidArgumentException(sprintf('Undefined _page_proxy_id'));
        }

        return $page_elementable;
    }
}
