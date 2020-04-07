<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ProductList;

// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementListController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ProductListViewer;
// commerce models
use Softworx\RocXolid\Commerce\Models\Product;

/**
 * @todo: docblock
 */
class Controller extends AbstractPageElementListController
{
    protected static $model_viewer_type = ProductListViewer::class;

    protected static $containee_class = Product::class;

    // @todo: type hints
    protected function reattachContainees($model, $order_by)
    {
        if ($model->productCategory()->exists()) {
            $model->detachContainee('items');

            $model->productCategory->products()->orderBy($order_by)->get()->each(function (Product $product, $key) {
                $model->attachContainee('items', $product);
            });

            return $this;
        }

        return parent::reattachContainees($model, $order_by);
    }
}
