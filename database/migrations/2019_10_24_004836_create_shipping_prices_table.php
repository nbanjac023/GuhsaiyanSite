<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country_name');
            $table->double('price');
            $table->timestamps();
        });
        $data = [
            ['country_name' => 'Srbija', 'price' => '2'],
            ['counry_name' => 'Ostale', 'price' => '8.5'],
        ];
        DB::table('shipping_prices')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_prices');
    }
}
