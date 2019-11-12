<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\DeliveryList;

// requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel,
    Softworx\RocXolid\Models\Contracts\Containee,
    Softworx\RocXolid\Models\Contracts\Container;
// general components
use Softworx\RocXolid\Components\General\Message,
    Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ContainerViewer;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
// cms repositories
use Softworx\RocXolid\CMS\Repositories\DeliveryList\Repository;
// cms models
use Softworx\RocXolid\CMS\Models\DeliveryList;
// commerce models
use Softworx\RocXolid\Commerce\Models\DeliveryMethod;

use Softworx\RocXolid\CMS\Http\Controllers\Traits\HasContainer;
/**
 *
 */
class Controller extends AbstractPageElementController
{
    use HasContainer;

    protected static $model_class = DeliveryList::class;

    protected static $repository_class = Repository::class;

    protected static $containee_class = DeliveryMethod::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'create.page-elements' => 'create-in-page-elementable',
        'store.page-elements' => 'create-in-page-elementable',
        'edit.page-elements' => 'update-in-page-elementable',
        'update.page-elements' => 'update-in-page-elementable',
        'listContainee' => 'list-containee',
        'selectContainee' => 'list-containee',
    ];
}