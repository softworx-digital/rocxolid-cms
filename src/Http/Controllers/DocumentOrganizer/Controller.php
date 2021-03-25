<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\DocumentOrganizer;

// rocXolid utils
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Repositoryable;
use Softworx\RocXolid\Contracts\Modellable;
use Softworx\RocXolid\Http\Controllers\Contracts\Dashboardable;
use Softworx\RocXolid\Repositories\Contracts\Repository;
use Softworx\RocXolid\Models\Contracts\Sortable;
// rocXolid traits
use Softworx\RocXolid\Traits as rxTraits;
use Softworx\RocXolid\Http\Controllers\Traits as rxControllerTraits;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractController;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\DocumentType;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\Dashboard\DocumentOrganization as DocumentOrganizationDashboard;

/**
 * Controller to handle documents and document types organization.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Controller extends AbstractController implements Repositoryable, Modellable, Dashboardable
{
    use rxTraits\Repositoryable;
    use rxTraits\Modellable;
    use rxControllerTraits\Dashboardable;
    use rxControllerTraits\Components\ModelViewerComponentable;

    protected static $dashboard_type = DocumentOrganizationDashboard::class;

    /**
     * {@inheritDoc}
     */
    protected $default_services = [
    ];

    /**
     * Model type to work with.
     *
     * @var string
     */
    protected static $model_type = DocumentType::class;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse $response
     * @param \Softworx\RocXolid\Repositories\Contracts\Repository $repository
     */
    public function __construct(AjaxResponse $response, Repository $repository)
    {
        // @todo !!! find some way to pass attribute to CrudPolicy::before() check
        // causes problems this way
        $this->authorizeResource(static::getModelType(), static::getModelType()::getAuthorizationParameter());

        $this
            ->setResponse($response)
            ->setRepository($repository->init(static::getModelType()))
            ->bindServices()
            ->init();
    }

    /**
     * Display options to generate various documents.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     */
    public function index(CrudRequest $request)
    {
        $assignments = collect([
            'document_organizer_controller' => $this,
            'document_type_repository' => app(Repository::class)->init(self::getModelType()),
        ]);

        return $this
            ->getDashboard()
            ->render('default', [ 'assignments' => $assignments ]);
    }

    /**
     * Save the position of documents and document types.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @todo quite ugly & put it some general trait
     */
    public function savePosition(CrudRequest $request)
    {
        collect(collect($request->input('_data'))->first())->each(function (array $tuple, int $position) {
            $id = $tuple['itemId'] ?? null;
            $type = $tuple['itemType'] ?? null;

            // @todo
            if (is_null($type)) {
                throw new \InvalidArgumentException('Item type is required');
            } elseif (!class_exists($type)) {
                throw new \InvalidArgumentException(sprintf('Item type [%s] does not exist', $type));
            } elseif (!collect(class_implements($type))->contains(Sortable::class)) {
                throw new \InvalidArgumentException(sprintf('Invalid item type [%s] for setting position', $type));
            }

            $type::findOrFail($id)->setPosition($position)->save();
        });

        $model_viewer_component = $this->getModelViewerComponent();

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }

    /**
     * Retrieve model type to work with.
     *
     * @return string
     */
    public function getModelType(): string
    {
        return static::$model_type;
    }
}
