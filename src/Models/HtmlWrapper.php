<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Softworx\RocXolid\Models\Contracts\Cloneable;
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Traits\CanContain;
use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;
use Softworx\RocXolid\CMS\Models\PageTemplate;

/**
 *
 */
class HtmlWrapper extends AbstractPageElement implements Container
{
    use CanContain;

    protected $table = 'cms_page_element_html_wrapper';

    protected $fillable = [
        'web_id',
        'name',
        'html_wrap_open',
        'html_wrap_close'
    ];

    public function cloneContaineeRelations($original_page_elementable, $page_elementable)
    {
        $this->getContainees($original_page_elementable->getCCRelationParam())->each(function ($containee, $index) use ($page_elementable) {
            $this->attachContainee($page_elementable->getCCRelationParam(), $containee);
        });

        return $this;
    }

    protected function buildPageElementableRelationsAfter($original, $page_elementable_relation, Collection $clone_log): Cloneable
    {
        $page_elementable_relation->each(function ($original_page_template) use ($original,$clone_log) {
            if ($cloned_page_template = $original_page_template->getCloneableCloned($clone_log)) {
                $original->getContainees($original_page_template->getCCRelationParam())->each(function ($containee, $index) use ($cloned_page_template, $clone_log) {
                    if ($cloned_containee = $containee->getCloneableCloned($clone_log)) {
                        $this->attachContainee($cloned_page_template->getCCRelationParam(), $cloned_containee);
                    }
                });
            }
        });

        return $this;
    }

    protected function buildRelationsAfter(Collection $clone_log): Cloneable
    {
        if ($original = $this->getCloneableOriginal($clone_log)) {
            $this
                ->buildPageElementableRelationsAfter($original, $original->pageTemplates(), $clone_log)
                ->buildPageElementableRelationsAfter($original, $original->pageProxies(), $clone_log)
                ->buildPageElementableRelationsAfter($original, $original->pages(), $clone_log);
        }

        return $this;
    }
}
