<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_baskets', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('customer_code')->limit(8);
            $table->integer('user_id');
            $table->string('reference');
            $table->string('product');
            $table->integer('quantity');
            $table->date('created_at');

            $table->index(['id', 'customer_code', 'user_id', 'reference']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_baskets');
    }
}
