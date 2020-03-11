<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaintenanceMessageToHostnames extends Migration
{
    protected $system = true;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('hostnames', static function (Blueprint $table) {
            $table->string('maintenance_message')
                ->after('under_maintenance_since')
                ->nullable()
                ->comment('Optional message to display on the maintenance page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('hostnames', static function (Blueprint $table) {
            $table->dropColumn('maintenance_message');
        });
    }
}
