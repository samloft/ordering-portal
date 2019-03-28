<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('customer_code')->limit(8)->unique();
            $table->string('customer_name')->limit(32);
            $table->string('address_line_1')->limit(64);
            $table->string('address_line_2')->limit(64);
            $table->string('city')->limit(64);
            $table->string('country')->limit(64);
            $table->string('post_code')->limit(64);
            $table->string('invoice_customer_name')->limit(32);
            $table->string('invoice_customer_address_line_1')->limit(64);
            $table->string('invoice_customer_address_line_2')->limit(64);
            $table->string('invoice_customer_address_line_3')->limit(64);
            $table->string('invoice_customer_address_line_4')->limit(64);
            $table->string('invoice_customer_address_line_5')->limit(64);
            $table->string('vat_flag')->limit(2)->nullable();
            $table->string('currency')->limit(3);

            $table->primary('customer_code');
            $table->index('customer_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
