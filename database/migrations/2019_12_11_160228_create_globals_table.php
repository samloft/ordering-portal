<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('globals', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->text('value');
            $table->timestamps();
        });

        DB::table('globals')->insert([
            'key'   => 'company-details',
            'value' => json_encode([
                'line_1'    => 'Address Line 1',
                'line_2'    => 'Address Line 2',
                'line_3'    => 'Address Line 3',
                'line_4'    => 'Address Line 4',
                'line_5'    => 'Address Line 5',
                'postcode'  => 'Postcode',
                'telephone' => 'Telephone',
                'email'     => 'example@example.com',
                'social'    => [
                    'facebook'  => 'facebook-url',
                    'twitter'   => 'twitter-url',
                    'linkedin'  => 'linkedin-url',
                    'instagram' => 'instagram-url',
                    'youtube'   => 'youtube-url',
                ],
                'apps' => [
                    'apple'   => 'apple-app-url',
                    'android' => 'android-app-url',
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
    public function down()
    {
        Schema::dropIfExists('globals');
    }
}
