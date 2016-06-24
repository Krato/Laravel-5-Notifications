<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_notifications', function (Blueprint $table) {

            $table->increments('id');
            
            $table->string('name', 128);
            
            $table->string('description', 255);
            
            $table->timestamps();

        });


        Schema::create('group_notifications_model', function(Blueprint $table)
        {
            $table->increments('id');
            
            $table->integer('group_notifications_id')->unsigned();

            $table->integer('model_id')->unsigned();
            
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_notifications');
        Schema::drop('group_notifications_model');
    }
}
