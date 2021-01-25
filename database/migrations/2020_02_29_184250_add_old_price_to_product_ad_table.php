<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldPriceToProductAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_ads', function (Blueprint $table) {
            $table->double('old_price')->nullable();
            $table->double('old_price_rsd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_ads', function (Blueprint $table) {
            $table->dropColumn('old_price');
            $table->dropColumn('old_price');
        });
    }
}
