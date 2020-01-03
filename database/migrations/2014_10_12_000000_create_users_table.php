<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_code');
            $table->string('email')->unique();
            $table->string('password');
            $table->dateTime('password_updated')->nullable();
            $table->rememberToken();
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('admin')->default(0);
            $table->float('discount')->default(0);
            $table->boolean('can_order')->default(1);
            $table->string('api_token', 80)->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
