<?php

use Illuminate\Database\Migrations\Migration;

class AddCheckoutNoticeToGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('globals')->insert([
            'key' => 'checkout-notice',
            'value' => '',
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
        DB::table('globals')->where('key', 'checkout-notice')->delete();
    }
}
