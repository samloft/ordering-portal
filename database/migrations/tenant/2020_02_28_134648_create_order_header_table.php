<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_header', static function (Blueprint $table) {
            $table->string('order_number')->unique();
            $table->string('customer_code');
            $table->integer('user_id');
            $table->string('reference');
            $table->string('notes')->nullable();
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->string('address_line_3')->nullable();
            $table->string('address_line_4')->nullable();
            $table->string('address_line_5');
            $table->string('delivery_method');
            $table->string('delivery_code');
            $table->float('delivery_cost');
            $table->float('small_order_charge');
            $table->float('value');
            $table->boolean('imported')->default(0);
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
        Schema::dropIfExists('order_header');
    }
}
