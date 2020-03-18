<?php

namespace Softworx\RocXolid\CMS\Models\Forms;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
use Softworx\RocXolid\Forms\Fields\Type\CollectionRadioList;
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckboxList;
use Softworx\RocXolid\Common\Filters\BelongsToWeb;

/**
 *
 */
class AbstractListContainee extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'containee_id' => [
            'type' => CollectionCheckboxList::class, // tu bude checkbox list
            'options' => [
                // 'collection' => ...adjusted
                'label' => [
                    'title' => 'containees',
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

    protected $containee_model = null;

    public function setContaineeClass($containee_class)
    {
        $this->containee_model = new $containee_class();

        $this->fields = array_merge_recursive($this->fields, [
            'containee_id' => [
                'options' => [
                    'except-attributes' => property_exists($containee_class, 'list_except_attributes') ? $containee_class::$list_except_attributes : null,
                    'collection' => [
                        'model' => $containee_class,
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

    public function getContaineeModel()
    {
        return $this->containee_model;
    }

    protected function adjustFieldsDefinition($fields)
    {

/*
        $fields = array_merge_recursive($fields, [
            'page_element_id' => [
                'options' => [
                    'collection' => [
                        'model' => Country::class,
                        'column' => 'name',
                        'filters' => [
                            [
                                'class' => BelongsToWeb::class,
                                'data' => $this->getModel()->web
                            ],
                        ],
                    ],
                ],
            ],
        ]);
*/
        return $fields;
    }
}
