<?php

namespace Softworx\RocXolid\CMS\Models;

use DB;
use Config;
use File as LaravelFile;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocxolid fundamentals
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Models\Contracts\Cloneable;
// model contracts
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
// common models
use Softworx\RocXolid\Common\Models\File;
use Softworx\RocXolid\Common\Models\Image;
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
// cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;
use Softworx\RocXolid\CMS\Models\PageTemplate;

// commerce models

/**
 *
 */
class WebFrontpageSettings extends AbstractCrudModel
{
    use SoftDeletes;
    use HasWeb;
    use UserGroupAssociatedWeb;

    protected $table = 'cms_web_frontpage_settings';

    protected $fillable = [
        'web_id',
        'name',
        'template_set',
        //'css',
        //'js',
        'schema',
        'facebook_page_url',
        'google_plus_page_url',
        'youtube_page_url',
        'google_analytics_tracking_code',
        'google_tag_manager_container_id',
        'livechatoo_account',
        'livechatoo_language',
        'livechatoo_side',
        'dognet_account_id',
        'dognet_campaign_id',
        'twitter_card',
        'twitter_site',
        'twitter_creator',
    ];

    protected $relationships = [
        'web',
        //'cssFiles',
        //'jsFiles',
    ];

    protected $system = [
        'css',
        'js',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $image_sizes = [
        'logo' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 180, 'height' => 55, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            //'fb' => [ 'width' => 474, 'height' => 145, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'default' => [ 'width' => 474, 'height' => 145, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
        'logoInverted' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 300, 'height' => 74, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
        'favicon' => [
            // apple-touch-icon
            '57x57' => [ 'width' => 57, 'height' => 57, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '60x60' => [ 'width' => 60, 'height' => 60, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '72x72' => [ 'width' => 72, 'height' => 72, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '76x76' => [ 'width' => 76, 'height' => 76, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '114x114' => [ 'width' => 114, 'height' => 114, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '120x120' => [ 'width' => 120, 'height' => 120, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '144x144' => [ 'width' => 144, 'height' => 144, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '152x152' => [ 'width' => 152, 'height' => 152, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '180x180' => [ 'width' => 180, 'height' => 180, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            // image/png
            '16x16' => [ 'width' => 16, 'height' => 16, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '32x32' => [ 'width' => 32, 'height' => 32, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '96x96' => [ 'width' => 96, 'height' => 96, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '192x192' => [ 'width' => 192, 'height' => 192, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            // msapplication
            '144x144' => [ 'width' => 144, 'height' => 144, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '192x192' => [ 'width' => 162, 'height' => 192, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
        ],
    ];

    public $clone_log;

    public function getTemplateSetsOptions()
    {
        $template_sets = collect();

        $views = Config::get('view.paths');
        $path = dirname(reset($views));
        $path = sprintf('%s/template-sets/*', $path);

        (collect(LaravelFile::glob($path)))->each(function ($file_path, $key) use ($template_sets) {
            $pathinfo = pathinfo($file_path);

            $template_sets->put($pathinfo['filename'], $pathinfo['filename']);
        });

        return $template_sets;
    }

    public function destroyCmsStructure()
    {
        Page::make()->getAllPageElementModels()->each(function ($page_element_model, $short_kebab_name) {
            $this
                ->destroyClassObjects($page_element_model);
        });

        $this
            ->destroyClassObjects(Page::class)
            ->destroyClassObjects(PageProxy::class)
            ->destroyClassObjects(PageTemplate::class);

        return $this;
    }

    public function cloneCmsStructure(Web $web)
    {
        $this->clone_log = collect();

        Page::make()->getAllPageElementModels()->each(function ($page_element_model, $short_kebab_name) use ($web) {
            $this
                ->cloneClassObjects($page_element_model, $web);
        });

        $this
            ->cloneClassObjects(Page::class, $web)
            ->cloneClassObjects(PageProxy::class, $web)
            ->cloneClassObjects(PageTemplate::class, $web);

        return $this;
    }

    public function buildCmsStructure()
    {
        Page::make()->getAllPageElementModels()->each(function ($page_element_model, $short_kebab_name) {
            $this
                ->buildClassObjects($page_element_model);
        });

        $this
            ->buildClassObjects(Page::class)
            ->buildClassObjects(PageProxy::class)
            ->buildClassObjects(PageTemplate::class);

        return $this;
    }

    public function getCloningOutput()
    {
        return $this->cloning_output;
    }

    public function logo()
    {
        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'logo')->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }

    public function logoInverted()
    {
        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'logoinverted')->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }

    public function favicon()
    {
        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'favicon')->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }

    public function cssFiles()
    {
        return $this->morphMany(File::class, 'model')->where(sprintf('%s.model_attribute', (new File())->getTable()), 'cssFiles')->orderBy(sprintf('%s.model_attribute_position', (new File())->getTable()));
    }

    public function jsFiles()
    {
        return $this->morphMany(File::class, 'model')->where(sprintf('%s.model_attribute', (new File())->getTable()), 'jsFiles')->orderBy(sprintf('%s.model_attribute_position', (new File())->getTable()));
    }

    public function pages()
    {
        return Page::where('web_id', $this->web->getKey());
    }

    public function pageProxies()
    {
        return PageProxy::where('web_id', $this->web->getKey());
    }

    public function pageTemplates()
    {
        return PageTemplate::where('web_id', $this->web->getKey());
    }

    protected function destroyClassObjects($class)
    {
        $class::where('web_id', $this->web->getKey())->each(function ($object, $id) {
            $object->forceDelete();
        });

        return $this;
    }

    protected function cloneClassObjects($class, Web $web)
    {
        $class::where('web_id', $web->getKey())->each(function ($object, $id) {
            if ($object instanceof Cloneable) {
                $clone = $object->clone($this->clone_log, [
                    'web_id' => $this->web->getKey(),
                ]);
            }
        });

        return $this;
    }

    protected function buildClassObjects($class)
    {
        $class::where('web_id', $this->web->getKey())->each(function ($object, $id) {
            if ($object instanceof Cloneable) {
                $object->buildRelations($this->clone_log);
            }
        });

        return $this;
    }
}
