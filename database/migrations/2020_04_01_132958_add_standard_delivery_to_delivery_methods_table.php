<?php

use Illuminate\Database\Migrations\Migration;

class AddStandardDeliveryToDeliveryMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('delivery_methods')->insert([
            'code' => 'HHHH',
            'title' => 'Standard Delivery',
            'identifier' => 'STANDARD DELIVERY',
            'price_low' => 0,
            'price' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::table('delivery_methods')->where('code', 'HHHH')->delete();
    }
}
