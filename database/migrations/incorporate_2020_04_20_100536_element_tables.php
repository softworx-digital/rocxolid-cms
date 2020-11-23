<?php

use Illuminate\Support\Str;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ElementTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
TODO: $table->index('order_number'); // indexy
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::dropIfExists('cms_page_has_elements');
        Schema::dropIfExists('cms_page_proxy_has_elements');
        Schema::dropIfExists('cms_page_template_has_elements');
        Schema::dropIfExists('cms_article_has_elements');
        Schema::dropIfExists('cms_document_has_elements');
        Schema::dropIfExists('cms_container_has_elements');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach ([ 'page_template', 'page', 'page_proxy', 'article', 'document' ] as $model_param) {
            Schema::create(sprintf('cms_%s_has_elements', $model_param), function (Blueprint $table) use ($model_param) {
                $table->unsignedInteger('parent_id');
                $table->morphs('element', sprintf('%s_elements_element_index', $model_param));

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
                    ->on(sprintf('cms_%s', Str::plural($model_param)))
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->primary([ 'parent_id', 'element_id', 'element_type' ], sprintf('%s_elements_primary_index', $model_param));
            });
        }

        Schema::create('cms_container_has_elements', function (Blueprint $table) {
            $table->morphs('container', 'container_elements_container_index');
            $table->morphs('element', 'container_elements_element_index');

            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_enabled')->default(1);
            $table->string('template')->default('default');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->primary([ 'container_id', 'container_type', 'element_id', 'element_type' ], 'container_elements_primary_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
