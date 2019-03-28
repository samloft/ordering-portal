<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('customer_code');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->dateTime('password_updated')->nullable();
            $table->rememberToken();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('evening_telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('admin')->default(0);
            $table->boolean('cms_admin')->default(0);
            $table->float('discount')->default(0);
            $table->integer('country_id')->default(1);
            $table->boolean('can_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
