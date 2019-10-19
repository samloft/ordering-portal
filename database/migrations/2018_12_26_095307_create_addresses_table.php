<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('addresses', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_code');
            $table->integer('user_id');
            $table->string('company_name');
            $table->string('address_line_2');
            $table->string('address_line_3');
            $table->string('address_line_4')->nullable();
            $table->string('address_line_5')->nullable();
            $table->integer('country_id');
            $table->string('post_code');
            $table->integer('default')->default(0);
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
        Schema::dropIfExists('addresses');
    }
}
