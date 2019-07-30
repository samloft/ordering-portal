<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_pages', function (Blueprint $table) {
            $table->string('page_name');
            $table->text('description');
            $table->timestamps();
        });

        DB::table('support_pages')->insert([
            'page_name' => 'terms-and-conditions',
            'description' => 'Terms & Conditions will go here',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('support_pages')->insert([
            'page_name' => 'data-protection',
            'description' => 'Data Protection will go here',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('support_pages')->insert([
            'page_name' => 'accessibility-policy',
            'description' => 'Accessibility Policy will go here',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_pages');
    }
}
