<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// rocXolid commerce models
use Softworx\RocXolid\CMS\Models;

class CreateCmsTables extends Migration
{
    protected const BLOCKABLES = [
        Models\Document::class => [
            Models\DocumentHeader::class,
            Models\DocumentFooter::class,
        ],
        Models\Page::class => [
            Models\PageHeader::class,
            Models\PageFooter::class,
        ],
    ];

    protected const ELEMENTABLES = [
        Models\Document::class,
        Models\DocumentHeader::class,
        Models\DocumentFooter::class,
        Models\Page::class,
        Models\PageHeader::class,
        Models\PageFooter::class,
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this
            ->dataDependencies()
            ->containerNavigations()
            ->containerFooters()
            ->containerSections()
            ->containerGridRows()
            ->containerGridColumns()
            ->containersPivot();

        collect(self::BLOCKABLES)->each(function (array $block_types) {
            collect($block_types)->each(function (string $block_type) {
                $this->blocks(Str::snake((new ReflectionClass($block_type))->getShortName()));
            });
        });

        $this
            ->documentTypes()
            ->documents()
            ->pageTemplates()
            ->pages()
            ->articleCategories()
            ->articles();

        collect(self::ELEMENTABLES)->each(function (string $type) {
            $this->elementsPivot(Str::snake((new ReflectionClass($type))->getShortName()));
        });
    }

    protected function dataDependencies(): self
    {
        Schema::create($this->prefixTable('data_dependencies'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');

            $table->boolean('is_enabled')->default(0);
            $table->enum('type', ['boolean', 'integer', 'decimal', 'string', 'text', 'enum', 'set']);
            $table->string('title');

            $table->decimal('min', 15, 6)->nullable();
            $table->decimal('max', 15, 6)->nullable();
            $table->boolean('is_required')->default(1);
            $table->boolean('default_value_boolean')->nullable();
            $table->integer('default_value_integer')->nullable();
            $table->decimal('default_value_decimal', 15, 6)->nullable();
            $table->string('default_value_string')->nullable();
            $table->text('default_value_text')->nullable();
            $table->enum('default_value_date', [ null, 'today' ])->nullable();
            $table->json('default_value_enum')->nullable();
            $table->json('default_value_set')->nullable();
            $table->string('yes_title')->nullable();
            $table->string('no_title')->nullable();
            $table->json('values');
            $table->string('conjunction')->nullable();

            $table->text('description')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function containerNavigations(): self
    {
        Schema::create($this->prefixTable('container_navigations'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');

            $table->string('name')->nullable();
            $table->string('bookmark')->nullable();
            $table->json('meta_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function containerFooters(): self
    {
        Schema::create($this->prefixTable('container_footers'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');

            $table->string('name')->nullable();
            $table->string('bookmark')->nullable();
            $table->json('meta_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function containerSections(): self
    {
        Schema::create($this->prefixTable('container_sections'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');

            $table->string('name')->nullable();
            $table->string('bookmark')->nullable();
            $table->json('meta_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function containerGridRows(): self
    {
        Schema::create($this->prefixTable('container_grid_rows'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');

            $table->string('name')->nullable();
            $table->json('meta_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });

        return $this;
    }

    protected function containerGridColumns(): self
    {
        Schema::create($this->prefixTable('container_grid_columns'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');

            $table->string('name')->nullable();
            $table->json('grid_layout')->nullable();
            $table->json('meta_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });

        return $this;
    }

    protected function containersPivot(): self
    {
        Schema::create($this->prefixTable('container_has_elements'), function (Blueprint $table) {
            $table->morphs('container', 'container_has_elements_container_index');
            $table->morphs('element', 'container_has_elements_element_index');

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);
            $table->string('template')->default('default');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->primary([ 'container_id', 'container_type', 'element_id', 'element_type' ], 'container_has_elements_primary_index');
        });

        return $this;
    }

    protected function documentTypes(): self
    {
        Schema::create($this->prefixTable('document_types'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this;
    }

    protected function documents(): self
    {
        Schema::create($this->prefixTable('documents'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->unsignedInteger('document_type_id');
            $table->unsignedInteger('document_header_id')->nullable();
            $table->unsignedInteger('document_footer_id')->nullable();

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);

            $table->string('title');
            $table->string('theme');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();

            $table->text('description');

            $table->json('dependencies');
            $table->json('dependencies_filters');
            $table->json('triggers');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('document_type_id')
                ->references('id')
                ->on($this->prefixTable('document_types'))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('document_header_id')
                ->references('id')
                ->on($this->prefixTable('document_headers'))
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('document_footer_id')
                ->references('id')
                ->on($this->prefixTable('document_footers'))
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function pageTemplates(): self
    {
        Schema::create($this->prefixTable('page_templates'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->unsignedInteger('page_template_id')->nullable();
            $table->unsignedInteger('page_header_id')->nullable();
            $table->unsignedInteger('page_footer_id')->nullable();

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);

            $table->string('name');
            $table->string('path');
            $table->string('path_regex')->nullable();
            $table->string('route_path');
            $table->string('theme');

            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_keywords');

            $table->string('open_graph_title');
            $table->text('open_graph_description');
            $table->string('open_graph_image');
            $table->string('open_graph_type');
            $table->string('open_graph_url');
            $table->string('open_graph_site_name');

            $table->text('description');

            $table->json('dependencies');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('page_template_id')
                ->references('id')
                ->on($this->prefixTable('page_templates'))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('page_header_id')
                ->references('id')
                ->on($this->prefixTable('page_headers'))
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('page_footer_id')
                ->references('id')
                ->on($this->prefixTable('page_footers'))
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function pages(): self
    {
        Schema::create($this->prefixTable('pages'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->unsignedInteger('page_template_id')->nullable();
            $table->unsignedInteger('page_header_id')->nullable();
            $table->unsignedInteger('page_footer_id')->nullable();

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);

            $table->string('name');
            $table->string('path');
            $table->string('path_regex')->nullable();
            $table->string('route_path');
            $table->string('theme');

            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_keywords');

            $table->string('open_graph_title');
            $table->text('open_graph_description');
            $table->string('open_graph_image');
            $table->string('open_graph_type');
            $table->string('open_graph_url');
            $table->string('open_graph_site_name');

            $table->text('description');

            $table->json('dependencies');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('page_template_id')
                ->references('id')
                ->on($this->prefixTable('page_templates'))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('page_header_id')
                ->references('id')
                ->on($this->prefixTable('page_headers'))
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('page_footer_id')
                ->references('id')
                ->on($this->prefixTable('page_footers'))
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function articleCategories(): self
    {
        Schema::create($this->prefixTable('article_categories'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this;
    }

    protected function articles(): self
    {
        Schema::create($this->prefixTable('articles'), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->unsignedInteger('author_id');

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);

            $table->date('date');
            $table->string('title');
            $table->string('slug');

            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_keywords');

            $table->longtext('perex');
            $table->longtext('content');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('author_id')
                ->references('id')
                ->on($this->prefixTable('users'));
        });

        return $this;
    }

    protected function blocks(string $param): self
    {
        Schema::create($this->prefixTable(Str::plural($param)), function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');

            $table->boolean('is_enabled')->default(0);
            $table->boolean('is_bound')->default(0);

            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function elementsPivot(string $param): self
    {
        Schema::create($this->prefixTable(sprintf('%s_has_elements', $param)), function (Blueprint $table) use ($param) {
            $table->unsignedInteger('parent_id');
            $table->morphs('element', sprintf('%s_has_elements_element_index', $param));

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);
            $table->string('template')->default('default');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('parent_id')
                ->references('id')
                ->on($this->prefixTable(Str::plural($param)))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary([ 'parent_id', 'element_id', 'element_type' ], sprintf('%s_has_elements_primary_index', $param));
        });

        return $this;
    }

    protected function prefixTable(string $table): string
    {
        return sprintf('%s%s', config('rocXolid.cms.general.table_prefix', ''), $table);
    }
}