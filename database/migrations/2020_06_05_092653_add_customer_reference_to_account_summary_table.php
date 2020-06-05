<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerReferenceToAccountSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('account_summary', static function (Blueprint $table) {
            $table->string('customer_reference')->after('reference')->nullable();
        });
    }
}
