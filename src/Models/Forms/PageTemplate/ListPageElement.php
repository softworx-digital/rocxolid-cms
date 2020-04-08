<?php

namespace Softworx\RocXolid\CMS\Models\Forms\PageTemplate;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
use Softworx\RocXolid\Forms\Fields\Type\CollectionRadioList;
use Softworx\RocXolid\Common\Filters\BelongsToWeb;

/**
 *
 */
class ListPageElement extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'page_element_id' => [
            'type' => CollectionRadioList::class,
            'options' => [
                // 'collection' => ...adjusted
                'label' => [
                    'title' => 'page_element',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
    ];

    protected $buttons = [
        // submit - default group
        'submit-ajax' => [
            'type' => ButtonSubmit::class,
            'options' => [
                'group' => ButtonGroup::DEFAULT_NAME,
                'ajax' => true,
                'label' => [
                    'title' => 'submit',
                ],
                'attributes' => [
                    'class' => 'btn btn-success',
                ],
            ],
        ],
    ];

    protected $page_element_model = null;

    public function setPageElementShortClass($page_element_short_class)
    {
        $page_element_models = $this->getModel()->getPageElementModels();
        $page_element_class = $page_element_models->get($page_element_short_class);

        $this->page_element_model = new $page_element_class();

        $this->fields = array_merge_recursive($this->fields, [
            'page_element_id' => [
                'options' => [
                    'collection' => [
                        'model' => $page_element_class,
                        //'column' => 'name',
                        'filters' => [
                            [
                                'class' => BelongsToWeb::class,
                                'data' => $this->getModel()->web
                            ],
                        ],
                        'validation' => [
                            'rules' => [
                                'required'
                            ]
                        ]
                    ],
                ],
            ],
        ]);

        $this->rebuildFields();

        return $this;
    }

    public function getPageElementModel()
    {
        return $this->page_element_model;
    }
}
