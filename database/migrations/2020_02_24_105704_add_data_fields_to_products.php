<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataFieldsToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('products', static function (Blueprint $table) {
            $table->boolean('obsolete')->default(false);
            $table->string('product_barcode')->nullable();
            $table->string('inner_barcode')->nullable();
            $table->string('outer_barcode')->nullable();
            $table->decimal('gross_weight', 8, 4)->nullable();
            $table->decimal('net_weight', 8, 4)->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('luckins_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('products', static function (Blueprint $table) {
            $table->dropColumn('obsolete');
            $table->dropColumn('product_barcode');
            $table->dropColumn('inner_barcode');
            $table->dropColumn('outer_barcode');
            $table->dropColumn('gross_weight');
            $table->dropColumn('net_weight');
            $table->dropColumn('length');
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->dropColumn('luckins_code');
        });
    }
}
