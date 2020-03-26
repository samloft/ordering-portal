<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerColumnsToHomeLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('home_links', static function (Blueprint $table) {
            $table->string('file')->nullable()->after('link');
            $table->string('style')->nullable()->after('position');
            $table->string('link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('home_links', static function (Blueprint $table) {
            $table->dropColumn('file');
            $table->dropColumn('style');
        });
    }
}
