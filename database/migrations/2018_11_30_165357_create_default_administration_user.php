<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultAdministrationUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert(
            array(
                'first_name' => 'Samuel',
                'last_name' => 'Loft',
                'email' => 'sam@scolmore.com',
                'username' => 'administrator',
                'customer_code' => 'SCO100',
                'password' => Hash::make('temp-password'),
                'password_updated' => date('Y-m-d H:i:s'),
                'admin' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'email_verified_at' => date('Y-m-d H:i:s')
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}