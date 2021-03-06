<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('prices', static function (Blueprint $table) {
            $table->string('customer_code');
            $table->string('product');
            $table->float('price');
            $table->integer('break1')->nullable();
            $table->float('price1')->nullable();
            $table->integer('break2')->nullable();
            $table->float('price2')->nullable();
            $table->integer('break3')->nullable();
            $table->float('price3')->nullable();

            $table->primary(['customer_code', 'product']);
            $table->index(['product', 'customer_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
}
