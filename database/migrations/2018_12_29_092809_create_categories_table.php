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
            $table->string('product')->primary();
            $table->string('cat1_level1')->nullable()->default(NULL);
            $table->string('cat1_level2')->nullable()->default(NULL);
            $table->string('cat1_level3')->nullable()->default(NULL);
            $table->string('cat1_level4')->nullable()->default(NULL);
            $table->string('cat1_level5')->nullable()->default(NULL);
//            $table->string('cat2_level1')->nullable()->default(NULL);
//            $table->string('cat2_level2')->nullable()->default(NULL);
//            $table->string('cat2_level3')->nullable()->default(NULL);
//            $table->string('cat2_level4')->nullable()->default(NULL);
//            $table->string('cat2_level5')->nullable()->default(NULL);
//            $table->string('cat3_level1')->nullable()->default(NULL);
//            $table->string('cat3_level2')->nullable()->default(NULL);
//            $table->string('cat3_level3')->nullable()->default(NULL);
//            $table->string('cat3_level4')->nullable()->default(NULL);
//            $table->string('cat3_level5')->nullable()->default(NULL);
//            $table->string('cat4_level1')->nullable()->default(NULL);
//            $table->string('cat4_level2')->nullable()->default(NULL);
//            $table->string('cat4_level3')->nullable()->default(NULL);
//            $table->string('cat4_level4')->nullable()->default(NULL);
//            $table->string('cat4_level5')->nullable()->default(NULL);
//            $table->string('cat5_level1')->nullable()->default(NULL);
//            $table->string('cat5_level2')->nullable()->default(NULL);
//            $table->string('cat5_level3')->nullable()->default(NULL);
//            $table->string('cat5_level4')->nullable()->default(NULL);
//            $table->string('cat5_level5')->nullable()->default(NULL);
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
