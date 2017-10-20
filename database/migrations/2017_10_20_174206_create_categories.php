<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // Schema::drop('categories');
       // Schema::drop('news');
        Schema::create( 'categories', function(Blueprint $table)
                       {
                           $table->increments('id')->primary();
                           $table->string('title');
                           $table->foreign('id')->references('id_categories')->on('news');
                       });
                       
        
        Schema::create('news', function(Blueprint $table)
                       {
                           $table->increments('id_news');
                           $table->string('name');
                           $table->string('title');
                           $table->string('author');
                           $table->integer('id_categories');
                           $table->longtext('content');
                           $table->dateTime('create_time');
                           $table->boolean('isLink');
                           
                       });
        //
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        //
    }
}
