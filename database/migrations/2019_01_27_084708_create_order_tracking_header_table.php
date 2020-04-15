<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTrackingHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_tracking_header', static function (Blueprint $table) {
            $table->string('order_number', 10);
            $table->string('base_order', 10);
            $table->string('reference', 20);
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
            $table->float('vat');
            $table->float('small_order_charge');
            $table->string('delivery_method');
            $table->float('delivery_cost');

            $table->primary(['order_number', 'base_order']);
            $table->index(['order_number', 'base_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tracking_header');
    }
}
