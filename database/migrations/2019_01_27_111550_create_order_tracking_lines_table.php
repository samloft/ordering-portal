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
    public function up(): void
    {
        Schema::create('order_tracking_lines', static function (Blueprint $table) {
            $table->string('order_number', 10);
            $table->integer('order_line_no');
            $table->string('product', 20);
            $table->string('description', 40);
            $table->integer('quantity');
            $table->float('net_price');
            $table->float('total');

            $table->primary(['order_number', 'product']);
            $table->index(['order_number', 'product']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tracking_lines');
    }
}
