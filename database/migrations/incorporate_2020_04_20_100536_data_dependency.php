<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataDependency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_data_dependencies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->enum('type', ['boolean', 'integer', 'decimal', 'string', 'text', 'enum', 'set']);
            $table->text('description')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        Schema::create('cms_data_dependency_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('data_dependency_id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('data_dependency_id')
                ->references('id')
                ->on('cms_data_dependencies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_data_dependency_values');
        Schema::dropIfExists('cms_data_dependencies');
    }
}
