<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->string('customer_code');
            $table->string('product');
            $table->float('price');
            $table->float('break1');
            $table->float('price1');
            $table->float('break2');
            $table->float('price2');
            $table->float('break3');
            $table->float('price3');

            $table->primary(['customer_code', 'product']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
