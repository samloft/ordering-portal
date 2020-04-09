<?php

use Illuminate\Database\Migrations\Migration;

class AddTermsEnabledToGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('globals')->insert([
            'key' => 'terms-enabled',
            'value' => json_encode([
                'enabled' => true,
                'url' => '',
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
        DB::table('globals')->where('key', 'terms-enabled')->delete();
    }
}
