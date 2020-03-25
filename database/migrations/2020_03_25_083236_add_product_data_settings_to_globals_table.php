<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductDataSettingsToGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('globals')->insert([
            'key' => 'product-data',
            'value' => json_encode([
                'data' => true,
                'prices' => true,
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
        DB::table('globals')->where('key', 'product-data')->delete();
    }
}
