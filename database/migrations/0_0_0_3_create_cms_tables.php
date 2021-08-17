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
TODO: $table->index('order_number'); // indexy
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
            ->articles()
            ->faqs();
    }
}