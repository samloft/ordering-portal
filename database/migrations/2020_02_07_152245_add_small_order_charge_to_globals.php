<?php

use Illuminate\Database\Migrations\Migration;

class AddSmallOrderChargeToGlobals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('globals')->insert([
            'key' => 'small-order-charge',
            'value' => json_encode([
                'threshold' => 0,
                'charge' => 0,
                'exclude_on_charge_delivery' => false,
                'exclude_on_collection' => false,
            ], true),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::table('globals')->where('key', 'small-order-charge')->delete();
    }
}
