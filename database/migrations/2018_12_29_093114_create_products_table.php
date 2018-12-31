<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->char('product')->primary()->limit(20)->default('');
            $table->char('type')->limit(1)->default('');
            $table->char('name')->limit(40);
            $table->char('uom')->limit(30)->default('');
            $table->char('pack_description')->limit(50)->default('');
            $table->integer('pack_quantity')->limit(11);
            $table->float('trade_price');
            $table->integer('order_multiples')->limit(11);
            $table->char('description')->limit(100);
            $table->char('note')->limit(100);
            $table->string('link1')->limit(100);
            $table->string('link2')->limit(100);
            $table->string('link3')->limit(100);
            $table->char('not_sold')->limit(1);
            $table->char('vat_flag')->limit(1)->default('');
            $table->char('discount_code')->limit(8);
            $table->char('packaging')->limit(11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
