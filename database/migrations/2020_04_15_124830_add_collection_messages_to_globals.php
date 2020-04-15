<?php

use Illuminate\Database\Migrations\Migration;

class AddCollectionMessagesToGlobals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('globals')->insert([
            'key' => 'collection-messages',
            'value' => json_encode([
                'default' => '',
                'times' => [
                    [
                        'start' => '00:00:00',
                        'end' => '11:00:00',
                        'message' => 'Your order will be ready for collection after 2PM on the same day',
                        'identifier' => 'COLLECTION AFTER 2PM SAME DAY',
                    ],
                ],
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
        DB::table('globals')->where('key', 'collection-messages')->delete();
    }
}
