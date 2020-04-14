<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_lines', static function (Blueprint $table) {
            $table->string('order_number');
            $table->string('product');
            $table->string('description')->nullable();
            $table->integer('quantity');
            $table->string('stock_type')->default('P');
            $table->float('net_price');
            $table->float('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
}
