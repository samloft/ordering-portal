<?php

use Illuminate\Database\Migrations\Migration;

class AddUploadSettingsToGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('globals')->insert([
            'key' => 'upload-config',
            'value' => json_encode([
                'prices' => true,
                'packs' => false,
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
        DB::table('globals')->where('key', 'upload-config')->delete();
    }
}
