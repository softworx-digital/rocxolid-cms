<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this
            ->webFrontpageSettings()
            ->basic()
            ->content()
            ->containers()
            ->containees()
            ->panels()
            ->forms()
            ->profile()
            ->shopping()
            ->proxies()
            ->specials()
            ->articles();
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('cms_page_element_contact');
        Schema::dropIfExists('cms_page_element_containee_navigation_item');
        Schema::dropIfExists('cms_page_element_containee_slider_item');
        Schema::dropIfExists('cms_page_element_container_delivery_list');
        Schema::dropIfExists('cms_page_element_container_main_navigation');
        Schema::dropIfExists('cms_page_element_container_main_slider');
        Schema::dropIfExists('cms_page_element_container_page_list');
        Schema::dropIfExists('cms_page_element_container_product_list');
        Schema::dropIfExists('cms_page_element_container_row_navigation');
        Schema::dropIfExists('cms_page_element_cookie_consent');
        Schema::dropIfExists('cms_page_element_footer_navigation');
        Schema::dropIfExists('cms_page_element_footer_note');
        Schema::dropIfExists('cms_page_element_forgot_password');
        Schema::dropIfExists('cms_page_element_gallery');
        Schema::dropIfExists('cms_page_element_html_wrapper');
        Schema::dropIfExists('cms_page_element_iframe_video');
        Schema::dropIfExists('cms_page_element_link');
        Schema::dropIfExists('cms_page_element_login_registration');
        Schema::dropIfExists('cms_page_element_newsletter');
        Schema::dropIfExists('cms_page_element_proxy_product');
        Schema::dropIfExists('cms_page_element_search_engine');
        Schema::dropIfExists('cms_page_element_shopping_after');
        Schema::dropIfExists('cms_page_element_shopping_cart');
        Schema::dropIfExists('cms_page_element_shopping_checkout');
        Schema::dropIfExists('cms_page_element_stats_panel');
        Schema::dropIfExists('cms_page_element_text');
        Schema::dropIfExists('cms_page_element_top_panel');
        Schema::dropIfExists('cms_page_element_user_profile');
        Schema::dropIfExists('cms_page_has_page_elements');
        Schema::dropIfExists('cms_page_proxy_has_page_elements');
        Schema::dropIfExists('cms_page_proxy');
        Schema::dropIfExists('cms_page_template_has_page_elements');
        Schema::dropIfExists('cms_page_template');
        Schema::dropIfExists('cms_page');
        Schema::dropIfExists('cms_web_frontpage_settings');
        Schema::dropIfExists('cms_page_element_container_article_list');
        Schema::dropIfExists('cms_article_has_page_elements');
        Schema::dropIfExists('cms_article');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function webFrontpageSettings()
    {
        Schema::create('cms_web_frontpage_settings', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('template_set')->nullable();
            $table->text('css')->nullable();
            $table->text('js')->nullable();
            $table->text('schema')->nullable();
            $table->string('facebook_page_url')->nullable();
            $table->string('facebook_app_id')->nullable();
            $table->string('google_plus_page_url')->nullable();
            $table->string('youtube_page_url')->nullable();
            $table->string('google_analytics_tracking_code')->nullable();
            $table->string('google_tag_manager_container_id')->nullable();
            $table->string('livechatoo_account')->nullable();
            $table->string('livechatoo_language')->nullable();
            $table->string('livechatoo_side')->nullable()->default('right');
            $table->string('dognet_account_id')->nullable();
            $table->string('dognet_campaign_id')->nullable();
            $table->string('twitter_card')->nullable();
            $table->string('twitter_site')->nullable();
            $table->string('twitter_creator')->nullable();
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

    protected function basic()
    {
        Schema::create('cms_page_template', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('seo_url_slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('open_graph_title')->nullable();
            $table->text('open_graph_description')->nullable();
            $table->string('open_graph_image')->nullable();
            $table->string('open_graph_type')->nullable();
            $table->string('open_graph_url')->nullable();
            $table->string('open_graph_site_name')->nullable();
            $table->text('description')->nullable();
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

        Schema::create('cms_page', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->unsignedInteger('page_template_id')->nullable();
            $table->string('name');
            $table->string('seo_url_slug')->nullable();
            $table->boolean('is_enabled')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('open_graph_title')->nullable();
            $table->text('open_graph_description')->nullable();
            $table->string('open_graph_image')->nullable();
            $table->string('open_graph_type')->nullable();
            $table->string('open_graph_url')->nullable();
            $table->string('open_graph_site_name')->nullable();
            $table->text('description')->nullable();
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

            $table->foreign('page_template_id')
                ->references('id')
                ->on('cms_page_template')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unique([ 'web_id', 'localization_id', 'seo_url_slug' ]);
        });

        Schema::create('cms_page_proxy', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->unsignedInteger('page_template_id')->nullable();
            $table->string('model_type');
            $table->string('name');
            $table->string('seo_url_slug')->nullable();
            $table->boolean('is_enabled')->default(0);
            $table->text('description')->nullable();
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

            $table->foreign('page_template_id')
                ->references('id')
                ->on('cms_page_template')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unique([ 'web_id', 'localization_id', 'model_type', 'seo_url_slug' ], 'cms_page_proxy_web_localization_model_slug_unique');
        });

        Schema::create('cms_page_template_has_page_elements', function (Blueprint $table) {
            $table->unsignedInteger('page_template_id');
            $table->unsignedInteger('page_element_id');
            $table->string('page_element_type');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_clone_page_element_instance')->default(0);
            $table->string('template')->default('default');

            $table->foreign('page_template_id')
                ->references('id')
                ->on('cms_page_template')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index(['page_element_id', 'page_element_type'], 'pt_has_pe_peid_petype_index');
            $table->primary(['page_template_id', 'page_element_id', 'page_element_type'], 'pt_has_pe_ptid_peid_petype_index');
        });

        Schema::create('cms_page_has_page_elements', function (Blueprint $table) {
            $table->unsignedInteger('page_id');
            $table->unsignedInteger('page_element_id');
            $table->string('page_element_type');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_visible')->default(1);
            $table->string('template')->default('default');

            $table->foreign('page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index(['page_element_id', 'page_element_type'], 'p_has_pe_peid_petype_index');
            $table->primary(['page_id', 'page_element_id', 'page_element_type'], 'p_has_pe_pid_peid_petype_index');
        });

        Schema::create('cms_page_proxy_has_page_elements', function (Blueprint $table) {
            $table->unsignedInteger('page_proxy_id');
            $table->unsignedInteger('page_element_id');
            $table->string('page_element_type');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_visible')->default(1);
            $table->string('template')->default('default');

            $table->foreign('page_proxy_id')
                ->references('id')
                ->on('cms_page_proxy')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index(['page_element_id', 'page_element_type'], 'pp_has_pe_peid_petype_index');
            $table->primary(['page_proxy_id', 'page_element_id', 'page_element_type'], 'pp_has_pe_pid_peid_petype_index');
        });

        return $this;
    }

    protected function content()
    {
        Schema::create('cms_page_element_html_wrapper', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->text('html_wrap_open');
            $table->text('html_wrap_close');
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

        Schema::create('cms_page_element_text', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name')->nullable();
            $table->string('bookmark')->nullable();
            $table->text('content')->nullable();
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

        Schema::create('cms_page_element_link', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');

            $table->string('name');
            $table->string('url')->nullable();
            $table->unsignedInteger('page_id')->nullable();
            $table->unsignedInteger('page_proxy_id')->nullable();
            $table->unsignedInteger('page_proxy_model_id')->nullable();

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

            $table->foreign('page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('page_proxy_id')
                ->references('id')
                ->on('cms_page_proxy')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_gallery', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name')->nullable();
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

        Schema::create('cms_page_element_iframe_video', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name')->nullable();
            $table->text('iframe');
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

    protected function containers()
    {
        Schema::create('cms_page_element_container_main_navigation', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
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
        }); // can contain NavigationItem (multiple levels)

        Schema::create('cms_page_element_container_row_navigation', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('title_note')->nullable();
            $table->string('default_template')->default('default'); // @todo: what for? check from code
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
        }); // can contain NavigationItem (one level)

        Schema::create('cms_page_element_container_main_slider', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('heading')->nullable();
            $table->text('text')->nullable();
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
        }); // can contain SliderItem

        Schema::create('cms_page_element_container_delivery_list', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('title');
            $table->text('title_note')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('subtitle_note')->nullable();
            $table->string('list')->nullable();
            $table->string('footer')->nullable();
            $table->text('footer_note')->nullable();
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
        }); // can contain DeliveryMethod

        Schema::create('cms_page_element_container_product_list', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('product_category_id')->nullable();
            $table->enum('container_fill_type', ['auto', 'manual'])->default('auto');
            $table->string('container_auto_order_by_attribute')->nullable();
            $table->enum('container_auto_order_by_direction', ['asc', 'desc'])->nullable();
            $table->string('name');
            $table->string('title');
            $table->text('text');
            $table->string('all_products');
            $table->string('filter');
            $table->unsignedInteger('containee_page_proxy_id');
            $table->string('containee_button');
            $table->string('containee_price_vat_label');
            $table->string('page_prev');
            $table->string('page_next');
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

            /*
            $table->foreign('product_category_id', 'cpecpl_product_category_id_foreign')
                ->references('id')
                ->on('product_categories')
                ->onDelete('set null')
                ->onUpdate('cascade');
            */

            $table->foreign('containee_page_proxy_id', 'cpecpl_containee_page_proxy_id_foreign')
                ->references('id')
                ->on('cms_page_proxy')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        }); // can contain Product

        Schema::create('cms_page_element_container_page_list', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('page_template_id');
            $table->string('name');
            $table->string('title');
            $table->string('subtitle');
            $table->string('button');
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

            $table->foreign('page_template_id')
                ->references('id')
                ->on('cms_page_template')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        }); // can contain page of defined type (by page_template_id)

        return $this;
    }

    protected function containees()
    {
        Schema::create('cms_page_element_containee_slider_item', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name')->nullable();
            $table->text('text')->nullable();
            $table->string('button')->nullable();
            $table->string('is_right')->nullable(); // @todo: change to position select
            $table->string('background_color')->nullable();
            $table->string('name_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('page_id')->nullable();
            $table->unsignedInteger('page_proxy_id')->nullable();
            $table->unsignedInteger('page_proxy_model_id')->nullable();
            $table->string('template')->default('default');
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

            $table->foreign('page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('page_proxy_id')
                ->references('id')
                ->on('cms_page_proxy')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_containee_navigation_item', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('product_category_id')->nullable();
            $table->string('name')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('css_class')->nullable();
            $table->text('text')->nullable();
            $table->string('button')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('page_id')->nullable();
            $table->unsignedInteger('page_proxy_id')->nullable();
            $table->unsignedInteger('page_proxy_model_id')->nullable();

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
            /*
            $table->foreign('product_category_id', 'cpe_navigation_item_product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('set null')
                ->onUpdate('cascade');
            */

            $table->foreign('page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('page_proxy_id')
                ->references('id')
                ->on('cms_page_proxy')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function panels()
    {
        Schema::create('cms_page_element_top_panel', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');

            $table->string('search');
            $table->unsignedInteger('search_page_id')->nullable();

            $table->string('login');
            $table->unsignedInteger('profile_page_id')->nullable();

            $table->string('logout');
            $table->unsignedInteger('logout_page_id')->nullable();

            $table->string('login_panel');
            $table->string('form_field_email');
            $table->string('form_field_password');
            $table->string('form_field_remember_me');
            $table->string('form_error');

            $table->string('forgot_password');
            $table->unsignedInteger('forgot_password_page_id')->nullable();

            $table->string('button_login');
            $table->string('button_register');
            $table->unsignedInteger('button_register_page_id')->nullable();

            $table->string('cart');
            $table->unsignedInteger('cart_page_id')->nullable();

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

            $table->foreign('search_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('profile_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('logout_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('forgot_password_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('button_register_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('cart_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_footer_navigation', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');

            $table->string('delivery')->nullable();
            $table->unsignedInteger('delivery_page_id')->nullable();

            $table->string('privacy')->nullable();
            $table->unsignedInteger('privacy_page_id')->nullable();

            $table->string('gtc')->nullable();
            $table->unsignedInteger('gtc_page_id')->nullable();

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

            $table->foreign('delivery_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('privacy_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('gtc_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_footer_note', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');

            $table->string('title')->nullable();
            $table->string('copyright')->nullable();
            $table->string('author')->nullable();

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

        Schema::create('cms_page_element_stats_panel', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('counter_1_text');
            $table->string('counter_1_value');
            $table->string('counter_2_text');
            $table->string('counter_2_value');
            $table->string('counter_3_text');
            $table->string('counter_3_value');
            $table->string('counter_4_text');
            $table->string('counter_4_value');
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

    protected function forms()
    {
        Schema::create('cms_page_element_contact', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_value')->nullable();
            $table->string('email')->nullable();
            $table->string('email_value')->nullable();
            $table->string('address')->nullable();
            $table->text('address_value')->nullable();
            $table->text('address_map_iframe')->nullable();
            $table->string('form_field_name')->nullable();
            $table->string('form_field_email')->nullable();
            $table->string('form_field_message')->nullable();
            $table->string('form_field_button')->nullable();
            $table->text('form_success')->nullable();
            $table->text('form_error_name_required')->nullable();
            $table->text('form_error_email_required')->nullable();
            $table->text('form_error_email_invalid')->nullable();
            $table->text('form_error_message_required')->nullable();
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

        Schema::create('cms_page_element_newsletter', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('text');
            $table->string('text_mobile');
            $table->string('form_field_email');
            $table->string('form_button');
            $table->string('form_error');
            $table->string('form_success');
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

    protected function profile()
    {
        Schema::create('cms_page_element_login_registration', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');

            $table->string('login_form_title');
            $table->string('login_form_field_email');
            $table->string('login_form_field_password');
            $table->string('login_form_foot_note');
            $table->string('login_form_button');
            $table->string('login_form_forgot_password');
            $table->unsignedInteger('login_form_forgot_password_page_id')->nullable();
            $table->string('login_form_error');
            $table->text('login_form_success')->nullable();

            $table->string('registration_form_title');
            $table->string('registration_form_field_type');
            $table->string('registration_form_field_type_natural_person');
            $table->string('registration_form_field_type_self_employed');
            $table->string('registration_form_field_type_legal_entity');
            $table->string('registration_form_field_company');
            $table->string('registration_form_field_company_registration_number');
            $table->string('registration_form_field_tax_id');
            $table->string('registration_form_field_vat_number');
            $table->string('registration_form_field_name');
            $table->string('registration_form_field_name_contact_person');
            $table->string('registration_form_field_surname');
            $table->string('registration_form_field_surname_contact_person');
            $table->string('registration_form_field_phone_number');
            $table->string('registration_form_field_email');
            $table->string('registration_form_field_password');
            $table->string('registration_form_field_password_repeat');
            $table->string('registration_form_field_address');
            $table->string('registration_form_field_address_detail');
            $table->string('registration_form_field_city');
            $table->string('registration_form_field_region');
            $table->string('registration_form_field_postal_code');
            $table->string('registration_form_field_country');
            $table->string('registration_form_field_gtc_agreement');
            $table->string('registration_form_field_newsletter');
            $table->string('registration_form_foot_note');
            $table->string('registration_form_button');
            $table->string('registration_form_error_company');
            $table->string('registration_form_error_company_registration_number_required');
            $table->string('registration_form_error_tax_id_required');
            $table->string('registration_form_error_vat_number_required');
            $table->string('registration_form_error_vat_number_invalid');
            $table->string('registration_form_error_name_required');
            $table->string('registration_form_error_surname_required');
            $table->string('registration_form_error_phone_number_required');
            $table->string('registration_form_error_phone_number_invalid');
            $table->string('registration_form_error_phone_number_used');
            $table->string('registration_form_error_email_required');
            $table->string('registration_form_error_email_invalid');
            $table->string('registration_form_error_email_used');
            $table->string('registration_form_error_password');
            $table->string('registration_form_error_gtc_agreement');
            $table->string('registration_form_error');
            $table->text('registration_form_success')->nullable();
            $table->unsignedInteger('registration_form_success_page_id')->nullable();

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

            $table->foreign('login_form_forgot_password_page_id', 'cms_pelg_fp_page_id_foreign')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('registration_form_success_page_id', 'cms_pelg_rfs_page_id_foreign')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_user_profile', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');

            $table->string('title');
            $table->string('subtitle')->nullable();

            $table->unsignedInteger('profile_page_id')->nullable();

            $table->string('profile_data', 100);
            $table->string('profile_data_change_button', 100);
            $table->unsignedInteger('profile_data_page_id')->nullable();

            $table->string('credentials', 100);
            $table->string('credentials_change_button', 100);
            $table->unsignedInteger('credentials_page_id')->nullable();

            $table->string('orders_history', 100);
            $table->string('orders_history_order_number', 100);
            $table->string('orders_history_order_date', 100);
            $table->string('orders_history_order_price', 100);
            $table->string('orders_history_empty', 100);

            $table->string('order_print_invoice', 100);
            $table->string('order_show', 100);
            $table->string('order_hide', 100);
            $table->string('order_repeat', 100);
            $table->string('order_price', 100);
            $table->string('order_discount', 100);
            $table->string('order_delivery', 100);
            $table->string('order_price_final', 100);
            $table->string('order_empty', 100);

            $table->string('order_item_name', 100);
            $table->string('order_item_quantity', 100);
            $table->string('order_item_price', 100);

            $table->string('profile_form_title_personal', 100);
            $table->string('profile_form_field_type', 100);
            $table->string('profile_form_field_type_natural_person', 100);
            $table->string('profile_form_field_type_self_employed', 100);
            $table->string('profile_form_field_type_legal_entity', 100);
            $table->string('profile_form_field_company', 100);
            $table->string('profile_form_field_company_registration_number', 100);
            $table->string('profile_form_field_tax_id', 100);
            $table->string('profile_form_field_vat_number', 100);
            $table->string('profile_form_field_name', 100);
            $table->string('profile_form_field_name_contact_person', 100);
            $table->string('profile_form_field_surname', 100);
            $table->string('profile_form_field_surname_contact_person', 100);
            $table->string('profile_form_field_phone_number', 100);
            $table->string('profile_form_field_email', 100);

            $table->string('profile_form_title_address', 100);
            $table->string('profile_form_field_address', 100);
            $table->string('profile_form_field_address_detail', 100);
            $table->string('profile_form_field_city', 100);
            $table->string('profile_form_field_region', 100);
            $table->string('profile_form_field_postal_code', 100);
            $table->string('profile_form_field_country', 100);
            $table->string('profile_form_field_newsletter', 100);
            $table->string('profile_form_button', 100);
            $table->string('profile_form_button_back', 100);
            $table->string('profile_form_foot_note', 100);

            $table->string('profile_form_error_company', 100);
            $table->string('profile_form_error_company_registration_number_required', 100);
            $table->string('profile_form_error_tax_id_required', 100);
            $table->string('profile_form_error_vat_number_required', 100);
            $table->string('profile_form_error_vat_number_invalid', 100);
            $table->string('profile_form_error_name_required', 100);
            $table->string('profile_form_error_surname_required', 100);
            $table->string('profile_form_error_phone_number_required', 100);
            $table->string('profile_form_error_phone_number_invalid', 100);
            $table->string('profile_form_error_phone_number_used', 100);
            $table->string('profile_form_error_email_required', 100);
            $table->string('profile_form_error_email_invalid', 100);
            $table->string('profile_form_error_email_used', 100);

            $table->text('profile_form_success')->nullable();

            $table->string('credentials_form_title', 100);
            $table->string('credentials_form_field_password', 100);
            $table->string('credentials_form_field_password_repeat', 100);
            $table->string('credentials_form_button', 100);
            $table->string('credentials_form_foot_note', 100);

            $table->string('credentials_form_error_password', 100);

            $table->text('credentials_form_success')->nullable();

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

            $table->foreign('profile_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('profile_data_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('credentials_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_forgot_password', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');

            $table->string('form_title');
            $table->string('form_title_note');

            $table->string('form_field_email');
            $table->string('form_button');
            $table->string('form_foot_note');
            $table->string('form_error');
            $table->text('form_success');

            $table->unsignedInteger('reset_page_id')->nullable();

            $table->string('reset_form_title');
            $table->string('reset_form_field_new_password');
            $table->string('reset_form_field_new_password_repeat');
            $table->string('reset_form_button');
            $table->string('reset_form_error_password_required');
            $table->string('reset_form_error_password_invalid');
            $table->string('reset_form_error_user_invalid');
            $table->text('reset_form_success');

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

            $table->foreign('reset_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function shopping()
    {
        Schema::create('cms_page_element_shopping_cart', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('continue_shopping');
            $table->unsignedInteger('continue_shopping_page_id')->nullable();
            $table->string('checkout');
            $table->unsignedInteger('checkout_page_id')->nullable();
            $table->string('table_items_product');
            $table->string('table_items_quantity');
            $table->string('table_items_price_unit_vat');
            $table->string('table_items_price_total_vat');
            $table->string('discount_price');
            $table->string('discount_percent');
            $table->string('gift');
            $table->string('gift_for_price_above');
            $table->string('empty_cart');
            $table->text('free_delivery_text');
            $table->string('free_delivery_remaining_price');
            $table->string('free_delivery_price');
            $table->string('free_delivery_already');
            $table->string('free_delivery_for_free');
            $table->string('coupon_active');
            $table->string('coupon_active_clear');
            $table->string('coupon_possible');
            $table->string('coupon_possible_apply');
            $table->string('cart_price_vat');
            $table->string('cart_discount');
            $table->string('cart_price_total_vat');
            $table->string('help_phone_number');
            $table->string('help_note');

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

            $table->foreign('continue_shopping_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('checkout_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_shopping_checkout', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('cart_empty');
            $table->unsignedInteger('cart_page_id')->nullable();
            $table->unsignedInteger('success_page_id')->nullable();
            $table->unsignedInteger('failed_page_id')->nullable();
            $table->unsignedInteger('pending_page_id')->nullable();
            $table->string('tab_invoice_title', 100);
            $table->string('tab_invoice_already_registered', 100);
            $table->string('tab_invoice_login_form_field_email', 100);
            $table->string('tab_invoice_login_form_field_password', 100);
            $table->string('tab_invoice_login_form_field_remember', 100);
            $table->string('tab_invoice_login_form_error', 100);
            $table->string('tab_invoice_login_form_button', 100);
            $table->string('tab_invoice_login_form_forgot_password', 100);
            $table->unsignedInteger('tab_invoice_login_form_forgot_password_page_id')->nullable();
            $table->string('tab_invoice_form_option_guest', 100);
            $table->string('tab_invoice_form_option_register', 100);
            $table->string('tab_invoice_form_field_type', 100);
            $table->string('tab_invoice_form_field_type_natural_person', 100);
            $table->string('tab_invoice_form_field_type_self_employed', 100);
            $table->string('tab_invoice_form_field_type_legal_entity', 100);
            $table->string('tab_invoice_form_field_company', 100);
            $table->string('tab_invoice_form_field_company_registration_number', 100);
            $table->string('tab_invoice_form_field_tax_id', 100);
            $table->string('tab_invoice_form_field_vat_number', 100);
            $table->string('tab_invoice_form_field_name', 100);
            $table->string('tab_invoice_form_field_name_contact_person', 100);
            $table->string('tab_invoice_form_field_surname', 100);
            $table->string('tab_invoice_form_field_surname_contact_person', 100);
            $table->string('tab_invoice_form_field_phone_number', 100);
            $table->string('tab_invoice_form_field_address', 100);
            $table->string('tab_invoice_form_field_address_detail', 100);
            $table->string('tab_invoice_form_field_city', 100);
            $table->string('tab_invoice_form_field_region', 100);
            $table->string('tab_invoice_form_field_postal_code', 100);
            $table->string('tab_invoice_form_field_country', 100);
            $table->string('tab_invoice_form_field_email', 100);
            $table->string('tab_invoice_form_field_password', 100);
            $table->string('tab_invoice_form_field_password_repeat', 100);
            $table->string('tab_invoice_form_field_note', 100);
            $table->string('tab_invoice_form_field_option_delivery_invoice', 100);
            $table->string('tab_invoice_form_field_option_delivery_other', 100);
            $table->string('tab_invoice_delivery_form_field_name', 100);
            $table->string('tab_invoice_delivery_form_field_name_contact_person', 100);
            $table->string('tab_invoice_delivery_form_field_surname', 100);
            $table->string('tab_invoice_delivery_form_field_surname_contact_person', 100);
            $table->string('tab_invoice_delivery_form_field_address', 100);
            $table->string('tab_invoice_delivery_form_field_address_detail', 100);
            $table->string('tab_invoice_delivery_form_field_city', 100);
            $table->string('tab_invoice_delivery_form_field_region', 100);
            $table->string('tab_invoice_delivery_form_field_postal_code', 100);
            $table->string('tab_invoice_delivery_form_field_country', 100);
            $table->string('tab_invoice_form_button', 100);
            $table->string('tab_invoice_form_error_company', 100);
            $table->string('tab_invoice_form_error_company_registration_number_required', 100);
            $table->string('tab_invoice_form_error_company_registration_number_invalid', 100);
            $table->string('tab_invoice_form_error_tax_id_required', 100);
            $table->string('tab_invoice_form_error_vat_number_required', 100);
            $table->string('tab_invoice_form_error_vat_number_invalid', 100);
            $table->string('tab_invoice_form_error_name_required', 100);
            $table->string('tab_invoice_form_error_surname_required', 100);
            $table->string('tab_invoice_form_error_phone_number_required', 100);
            $table->string('tab_invoice_form_error_phone_number_invalid', 100);
            $table->string('tab_invoice_form_error_phone_number_used', 100);
            $table->string('tab_invoice_form_error_email_required', 100);
            $table->string('tab_invoice_form_error_email_invalid', 100);
            $table->string('tab_invoice_form_error_email_used', 100);
            $table->string('tab_invoice_form_error_password', 100);
            $table->string('tab_invoice_form_error_address_required', 100);
            $table->string('tab_invoice_form_error_postal_code_required', 100);
            $table->string('tab_invoice_form_error_city_required', 100);
            $table->string('tab_invoice_form_error_region_required', 100);
            $table->string('tab_invoice_form_error_gtc_agreement', 100);
            $table->string('tab_invoice_form_error', 100);
            $table->string('tab_payment_delivery_title', 100);
            $table->string('tab_payment_delivery_delivery_method_title', 100);
            $table->string('tab_payment_delivery_delivery_method_balikomat_address', 100);
            $table->string('tab_payment_delivery_delivery_method_parcelshop_address', 100);
            $table->string('tab_payment_delivery_error_payment_method_required', 100);
            $table->string('tab_payment_delivery_error_delivery_method_required', 100);
            $table->string('tab_payment_delivery_error_payment_failed', 100);
            $table->string('tab_summary_title', 100);
            $table->string('tab_summary_table_column_item', 100);
            $table->string('tab_summary_table_column_quantity', 100);
            $table->string('tab_summary_table_column_price', 100);
            $table->string('tab_summary_table_delivery', 100);
            $table->string('tab_summary_table_payment', 100);
            $table->string('tab_summary_table_discount', 100);
            $table->string('tab_summary_table_price_total_vat', 100);
            $table->string('tab_summary_form_field_gtc_agreement', 100);
            $table->string('tab_summary_form_field_privacy_agreement', 100);
            $table->string('tab_summary_form_field_newsletter_registration', 100);
            $table->string('tab_summary_form_foot_note', 100);
            $table->string('tab_summary_form_button', 100);
            $table->string('tab_summary_form_error_gtc_agreement_required', 100);
            $table->string('tab_summary_form_error_privacy_agreement_required', 100);
            $table->text('gtc');
            $table->text('privacy');
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

            $table->foreign('cart_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('success_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('failed_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('pending_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('tab_invoice_login_form_forgot_password_page_id', 'forgot_password_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('cms_page_element_shopping_after', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('title');
            $table->string('subtitle');
            $table->string('invalid_order');
            $table->string('home_button');
            $table->text('text');
            $table->string('form_field_text');
            $table->string('form_button');
            $table->string('form_error');
            $table->text('form_success');
            $table->string('fb_link');
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

    protected function proxies()
    {
        Schema::create('cms_page_element_proxy_product', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('no_images')->nullable();
            $table->string('rating')->nullable();
            $table->string('variants')->nullable();
            $table->string('quantity')->nullable();
            $table->string('sold_out')->nullable();
            $table->string('free_delivery')->nullable();
            $table->string('pieces')->nullable();
            $table->string('price_vat_label')->nullable();
            $table->string('add_to_cart')->nullable();
            $table->string('added_to_cart')->nullable();
            $table->string('continue_shopping')->nullable();
            $table->string('to_cart')->nullable();
            $table->unsignedInteger('cart_page_id')->nullable();
            $table->string('tab_description')->nullable();
            $table->string('tab_reviews')->nullable();
            $table->string('tab_faq')->nullable();
            $table->string('related_products')->nullable();
            $table->string('related_products_button')->nullable();
            $table->string('tab_reviews_add')->nullable();
            $table->string('tab_reviews_form_field_name')->nullable();
            $table->string('tab_reviews_form_field_content')->nullable();
            $table->string('tab_reviews_form_field_content_placeholder')->nullable();
            $table->string('tab_reviews_form_field_rating')->nullable();
            $table->string('tab_reviews_form_button')->nullable();
            $table->string('tab_reviews_login_to_add_review')->nullable();
            $table->string('tab_reviews_no_reviews')->nullable();
            $table->string('tab_faq_no_faqs')->nullable();
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

            $table->foreign('cart_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function specials()
    {
        Schema::create('cms_page_element_search_engine', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('form_field_phrase')->nullable();
            $table->string('form_field_button')->nullable();
            $table->string('results')->nullable();
            $table->string('results_button')->nullable();
            $table->text('results_empty')->nullable();
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

        Schema::create('cms_page_element_cookie_consent', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->text('text');
            $table->string('more_info');
            $table->string('button');
            $table->string('modal_title');
            $table->text('modal_body');
            $table->string('modal_close_button');
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

    protected function articles()
    {
        Schema::create('cms_article', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');
            $table->date('date');
            $table->string('name');
            $table->string('seo_url_slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('perex')->nullable();
            $table->boolean('is_enabled')->default(0);
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

        Schema::create('cms_article_has_page_elements', function (Blueprint $table) {
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('page_element_id');
            $table->string('page_element_type');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_visible')->default(1);
            $table->string('template')->default('default');

            $table->foreign('article_id')
                ->references('id')
                ->on('cms_article')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index(['page_element_id', 'page_element_type'], 'a_has_pe_peid_petype_index');
            $table->primary(['article_id', 'page_element_id', 'page_element_type'], 'a_has_pe_pid_peid_petype_index');
        });

        Schema::create('cms_page_element_container_article_list', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->enum('container_fill_type', ['auto', 'manual'])->default('auto');
            $table->string('container_auto_order_by_attribute')->nullable();
            $table->enum('container_auto_order_by_direction', ['asc', 'desc'])->nullable();
            $table->string('name');
            $table->string('title');
            $table->text('text');
            $table->string('all');
            $table->string('filter')->nullable();
            $table->unsignedInteger('containee_page_proxy_id');
            $table->string('containee_button');
            $table->string('page_prev');
            $table->string('page_next');
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

            $table->foreign('containee_page_proxy_id', 'cpecal_containee_page_proxy_id_foreign')
                ->references('id')
                ->on('cms_page_proxy')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        }); // can contain Article

        Schema::create('cms_page_element_proxy_article', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->string('back_button')->nullable();
            $table->unsignedInteger('back_page_id')->nullable();
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

            $table->foreign('back_page_id')
                ->references('id')
                ->on('cms_page')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;

    }

    private function importDump($table, $package = 'cms')
    {
        $file = realpath(sprintf('%s/../dumps/rocXolid/%s/%s.sql', __DIR__, $package, $table));

        DB::unprepared(file_get_contents($file));

        return $this;
    }
}