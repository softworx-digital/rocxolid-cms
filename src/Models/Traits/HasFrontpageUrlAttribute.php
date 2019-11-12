<?php

namespace Softworx\RocXolid\CMS\Models\Traits;
/**
 *
 */
trait HasFrontpageUrlAttribute
{
    public function getFrontpageUrl($attribute = null)
    {
        $attribute_page_proxy = is_null($attribute) ? 'page_proxy_id' : sprintf('%s_page_proxy_id', $attribute);
        $attribute_page_proxy_model = is_null($attribute) ? 'page_proxy_model_id' : sprintf('%s_page_proxy_model_id', $attribute);
        $attribute_page = is_null($attribute) ? 'page_id' : sprintf('%s_page_id', $attribute);
        $attribute_url = is_null($attribute) ? 'url' : sprintf('%s_url', $attribute);

        if (array_key_exists($attribute_url, $this->attributes) && !empty($this->$attribute_url))
        {
            return $this->$attribute_url;
        }
        elseif (array_key_exists($attribute_page, $this->attributes) && !empty($this->$attribute_page))
        {
            $relation = is_null($attribute) ? 'page' : sprintf('%sPage', camel_case($attribute));

            if (!method_exists($this, $relation))
            {
                throw new \RuntimeException(sprintf('Missing required relation method [%s] for [%s]', $relation, get_class($this)));
            }

            if (!$this->$relation()->exists()) // self cleaning
            {
                $this->$relation()->dissociate();

                return '#';
            }

            return $this->$relation->getFrontPageUrl();
        }
        elseif (array_key_exists($attribute_page_proxy, $this->attributes) && !empty($this->$attribute_page_proxy))
        {
            $relation = is_null($attribute) ? 'pageProxy' : sprintf('%sPageProxy', camel_case($attribute));

            if (!method_exists($this, $relation))
            {
                throw new \RuntimeException(sprintf('Missing required relation method [%s] for [%s]', $relation, get_class($this)));
            }

            if (!$this->$relation()->exists()) // self cleaning
            {
                $this->$relation()->dissociate();
                $this->$attribute_page_proxy_model = null;
                $this->save();

                return '#';
            }

            if (!array_key_exists($attribute_page_proxy_model, $this->attributes))
            {
                throw new \RuntimeException(sprintf('Missing required proxy model attribute [%s] for [%s]', $attribute_page_proxy_model, get_class($this)));
            }

            return $this->$relation->getFrontPageUrl($this->$attribute_page_proxy_model);
        }
        elseif (!array_key_exists($attribute_page, $this->attributes) && !array_key_exists($attribute_url, $this->attributes))
        {
            throw new \InvalidArgumentException(sprintf('Neither [%s] nor [%s] attribute of [%s] exists', $attribute_page, $attribute_url, (new \ReflectionClass($this))->getShortName()));
        }

        return '#';
    }

    public function hasFrontpageUrl($attribute = null)
    {
        return $this->getFrontpageUrl($attribute) != '#';
    }
}