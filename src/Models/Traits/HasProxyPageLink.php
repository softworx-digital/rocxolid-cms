<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

// rocXolid contracts
use Softworx\RocXolid\Forms\Contracts\Form,
    Softworx\RocXolid\Forms\Contracts\FormField;
// field types
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
// filters
use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// commerce models
use Softworx\RocXolid\CMS\Models\PageProxy;
/**
 *
 */
trait HasProxyPageLink
{
    private $_detected_page_proxy = [];

    public function pageProxy()
    {
        return $this->belongsTo(PageProxy::class);
    }

    public function detectPageProxy(Form $form, string $relation_name = 'pageProxy')
    {
        if (!isset($this->_detected_page_proxy[$relation_name]) || is_null($this->_detected_page_proxy[$relation_name]))
        {
            $param = sprintf('%s.%s_id', FormField::SINGLE_DATA_PARAM, snake_case($relation_name));

            $id = $form->getRequest()->input($param, null);

            if (is_null($id) && ($input = $form->getInput()))
            {
                $id = array_get($input, $param, null);
            }

            if (is_null($id) && ($this->$relation_name()->exists()))
            {
                $this->_detected_page_proxy[$relation_name] = $this->$relation_name;
            }
            else
            {
                $this->_detected_page_proxy[$relation_name] = PageProxy::find($id) ?: PageProxy::make();
            }
        }

        return $this->_detected_page_proxy[$relation_name];
    }

    public function adjustPageProxyModelFieldDefinition(Form $form, array &$fields, string $relation_name = 'pageProxy')
    {
        $param = $this->getProxyPageModelAttribute($relation_name);

        if ($this->detectPageProxy($form, $relation_name)->exists)
        {
            $fields[$param] = $this->getPageProxyModelFieldDefinition($this->detectPageProxy($form, $relation_name), $relation_name);
        }
        elseif (isset($fields[$param]))
        {
            unset($fields[$param]);
        }

        return $this;
    }

    public function getPageProxyModelFieldDefinition(PageProxy $page_proxy, string $relation_name = 'pageProxy')
    {
        $definition = [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => $page_proxy->model_type,
                    'column' => 'name',
                    'filters' => [[
                        'class' => BelongsToWeb::class,
                        'data' => $page_proxy->web,
                    ]]
                ],
                'label' => [
                    'title' => sprintf('%s_model', snake_case($relation_name)),
                ],
                'show_null_option' => true,
                'validation' => [
                    'rules' => [
                        sprintf('required_with:_data.%s', $this->$relation_name()->getForeignKey()),
                    ],
                ],
            ],
        ];

        if ($this->$relation_name()->exists())
        {
            $definition['options']['value'] = $this->$relation_name->id;
        }

        return $definition;
    }

    public function getPageProxyModelField(Form $form, PageProxy $page_proxy, string $relation_name = 'pageProxy')
    {
        $definition = $this->getPageProxyModelFieldDefinition($page_proxy, $relation_name);

        $field = $form->getFormFieldFactory()->makeField($form, $form, $definition['type'], $this->getProxyPageModelAttribute($relation_name), $definition['options']);
        /*
        if ($this->$relation_name()->exists())
        {
            $field->setValue($this->$relation_name->id);
        }
        */
        return $field;
    }

    public function getProxyPageModelAttribute(string $relation_name)
    {
        return sprintf('%s_model_id', snake_case($relation_name));
        //return $this->$relation_name()->getForeignKey();
    }
}