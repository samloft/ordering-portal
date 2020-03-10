<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_summary', function (Blueprint $table) {
            $table->string('customer_code')->limit(8);
            $table->string('item_no')->limit(20);
            $table->string('reference')->limit(20);
            $table->date('dated');
            $table->date('due_date');
            $table->float('unall_curr_amount');
            $table->string('age');

            $table->primary(['customer_code', 'item_no']);
            $table->index(['customer_code', 'item_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_summary');
    }
}
