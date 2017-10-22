<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Host extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('host');
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
        Schema::drop('hosts');
    }
}
