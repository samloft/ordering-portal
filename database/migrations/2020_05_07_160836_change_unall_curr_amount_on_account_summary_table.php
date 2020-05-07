<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUnallCurrAmountOnAccountSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('account_summary', static function (Blueprint $table) {
            $table->decimal('unall_curr_amount', 18, 2)->change();
        });
    }
}
