<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Word extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('word');
            $table->addColumn('integer', 'black_list_id', ['unsigned' => true, 'length' => 10])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('words');
    }
}
