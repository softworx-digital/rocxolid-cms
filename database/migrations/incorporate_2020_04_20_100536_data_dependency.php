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
TODO: $table->index('order_number'); // indexy
        Schema::create('cms_data_dependencies', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_enabled')->default(0);
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
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
