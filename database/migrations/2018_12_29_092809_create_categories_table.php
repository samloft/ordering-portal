<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->string('product')->limit(20);
            $table->string('cat1_level1')->nullable()->default(NULL);
            $table->string('cat1_level2')->nullable()->default(NULL);
            $table->string('cat1_level3')->nullable()->default(NULL);
            $table->string('cat1_level4')->nullable()->default(NULL);
            $table->string('cat1_level5')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
