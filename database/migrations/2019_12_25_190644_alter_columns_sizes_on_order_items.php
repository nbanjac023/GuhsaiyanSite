<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\OrderItem;

class AlterColumnsSizesOnOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('order_items', function (Blueprint $table) {

        // });

        $orderItems = OrderItem::all();
        foreach ($orderItems as $item) {
            if ($item->size == 'S,L') {
                $item->size = '10';
                $item->update();
            }
            if ($item->size == 'M,L') {
                $item->size = '12';
                $item->update();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
}
