<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('discounts', static function (Blueprint $table) {
            $table->string('customer_code');
            $table->float('percent');
            $table->timestamps();

            $table->primary('customer_code');
            $table->index('customer_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
}
