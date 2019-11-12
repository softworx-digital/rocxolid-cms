<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\ArticleList;

// requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// general components
use Softworx\RocXolid\Components\General\Message,
    Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent,
    Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
// cms controller traits
use Softworx\RocXolid\CMS\Http\Controllers\Traits\HasContainer;
// cms repositories
use Softworx\RocXolid\CMS\Repositories\ArticleList\Repository;
// cms models
use Softworx\RocXolid\CMS\Models\ArticleList;
// cms viewers
use Softworx\RocXolid\CMS\Components\ModelViewers\ArticleListViewer;
// cms models
use Softworx\RocXolid\CMS\Models\Article;
/**
 *
 * @todo Doplnit interface 'pre' HasContainer
 */
class Controller extends AbstractPageElementController
{
    use HasContainer {
        reattachContainees as protected traitReattachContainees;
    }

    protected static $model_class = ArticleList::class;

    protected static $repository_class = Repository::class;

    protected static $containee_class = Article::class;

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
        'listContaineeReplace' => 'list-containee-replace',
        'listContaineeReplaceSubmit' => 'list-containee-replace',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return (new ArticleListViewer())->setModel($model)->setController($this);
    }

    protected function reattachContainees($order_by)
    {
        return $this->traitReattachContainees($order_by);
    }
}