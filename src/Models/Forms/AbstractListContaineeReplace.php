<?php

namespace Softworx\RocXolid\CMS\Models\Forms;

use Illuminate\Support\Collection;
// rocXolid commerce forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid field types
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
use Softworx\RocXolid\Forms\Fields\Type\CollectionRadioList;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;

/**
 *
 */
class AbstractListContaineeReplace extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'order_by_attribute' => [
            'type' => CollectionSelect::class,
            'options' => [
                // 'collection' => ...adjusted
                'label' => [
                    'title' => 'sort_by',
                ],
                // 'show_null_option' => false,
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

    public function setContaineeClass($containee_class)
    {
        if (!property_exists($containee_class, 'list_sortable_attributes')) {
            throw new \RuntimeException(sprintf('Class [%s] does not contain property [%s]', $containee_class, 'list_sortable_attributes'));
        }

        // @todo refactor
        $containee_model_viewer_component = (new $containee_class())->getModelViewerComponent();

        $collection = collect();

        foreach ($containee_class::$list_sortable_attributes as $attribute) {
            $collection->put($attribute, $containee_model_viewer_component->translate(sprintf('field.%s', $attribute)));
        }

        $this->fields = array_merge_recursive($this->fields, [
            'order_by_attribute' => [
                'options' => [
                    'collection' => $collection,
                    'validation' => [
                        'rules' => [
                            'required'
                        ]
                    ],
                ],
            ],
        ]);

        $this->rebuildFields();

        return $this;
    }
}
