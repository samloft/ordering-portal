<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('promotions', static function (Blueprint $table) {
            $table->id();
            $table->string('product');
            $table->integer('product_qty');
            $table->string('promotion_product');
            $table->integer('promotion_qty');
            $table->string('claim_type');
            $table->integer('max_claims')->nullable();
            $table->string('restrictions')->nullable();
            $table->text('buying_groups')->nullable();
            $table->text('price_lists')->nullable();
            $table->text('discount_codes')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
}
