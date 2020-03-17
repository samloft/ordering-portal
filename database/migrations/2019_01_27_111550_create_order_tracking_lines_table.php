<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTrackingLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tracking_lines', function (Blueprint $table) {
            $table->string('order_no', 10);
            $table->integer('order_line_no');
            $table->string('product', 20);
            $table->string('long_description', 40);
            $table->integer('line_qty');
            $table->float('net_price');
            $table->float('line_val');

            $table->primary(['order_no', 'product']);
            $table->index(['order_no', 'product']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_tracking_lines');
    }
}