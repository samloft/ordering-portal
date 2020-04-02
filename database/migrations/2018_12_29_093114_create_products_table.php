<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->char('code')->primary();
            $table->char('type');
            $table->char('name');
            $table->char('uom');
            $table->float('trade_price');
            $table->integer('order_multiples');
            $table->integer('outer_box_qty')->nullable();
            $table->char('description');
            $table->char('note')->nullable();
            $table->string('link1')->nullable();
            $table->string('link2')->nullable();
            $table->string('link3')->nullable();
            $table->boolean('not_sold');
            $table->integer('stock')->default(0);
            $table->char('vat_flag')->default('S');
            $table->integer('packaging')->nullable();
            $table->boolean('obsolete')->default(false);
            $table->string('product_barcode')->nullable();
            $table->string('inner_barcode')->nullable();
            $table->string('outer_barcode')->nullable();
            $table->decimal('gross_weight', 8, 4)->nullable();
            $table->decimal('net_weight', 8, 4)->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('luckins_code')->nullable();

            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
