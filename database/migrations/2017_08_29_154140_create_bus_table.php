<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->string('designation');
            $table->string('matriculation')->unique();
            $table->string('chassis')->unique();
            $table->date('first_circulation');
            $table->integer('model_id')->unsinged();
            $table->integer('assurance_id')->unsigned();
            $table->integer('visit_id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->integer('site_id')->nullable();
            $table->timestamps();

            $table->foreign('model_id')->references('id')->on('models')
                 ->onUpdate('cascade')->onDelete('cascade');

           $table->foreign('assurance_id')->references('id')->on('assurances')
                 ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('visit_id')->references('id')->on('visits')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('assurances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->date('date');
            $table->integer('user_id')->nullable();
            $table->integer('site_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('site_id')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->date('date');
            $table->integer('user_id')->nullable();
            $table->integer('site_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('site_id')
                ->onUpdate('cascade')->onDelete('cascade');
        });
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
