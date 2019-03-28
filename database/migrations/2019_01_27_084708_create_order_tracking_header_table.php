<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTrackingHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tracking_header', function (Blueprint $table) {
            $table->string('order_no', 10)->primary();
            $table->string('base_order', 10);
            $table->string('customer_order_no', 20);
            $table->string('status', 20);
            $table->string('type', 20);
            $table->string('customer_code', 10);
            $table->string('invoice_customer', 10);
            $table->date('date_received');
            $table->date('date_required')->nullable();
            $table->date('date_despatched')->nullable();
            $table->date('date_invoiced')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('delivery_address1');
            $table->string('delivery_address2');
            $table->string('delivery_address3');
            $table->string('delivery_address4');
            $table->string('delivery_address5');
            $table->float('value');
            $table->string('invoice_address_1');
            $table->string('invoice_address_2');
            $table->string('invoice_address_3');
            $table->string('invoice_address_4');
            $table->string('consignment');
            $table->float('vat_value');
            $table->string('delivery_service');

            $table->primary(['order_no', 'base_order']);
            $table->index(['order_no', 'base_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_tracking_header');
    }
}
