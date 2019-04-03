<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('vehicles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('matriculation')->unique();
                $table->integer('step')->nullable();
                $table->string('chassis')->unique();
                $table->integer('model_id')->unsinged();
                $table->date('pmc')->nullable();
                $table->date('visit_expiration')->nullable();
                $table->date('insurance_expiration')->nullable();
                $table->integer('site_id')->nullable();
                $table->timestamps();

                /* $table->foreign('model_id')->references('id')->on('models')
                     ->onUpdate('cascade')->onDelete('cascade');

               /*$table->foreign('site_id')->references('id')->on('sites')
                     ->onUpdate('cascade')->onDelete('cascade');*/
            });

            Schema::create('fields', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('description');
                $table->timestamps();
            });

            Schema::create('states', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('vehicle_id')->unsigned();
                $table->integer('mileage')->unsigned();
                $table->integer('engine_mileage')->unsigned();
                $table->date('entered_at')->unsigned();
                $table->longText('incident')->nullable();
                $table->longText('report')->nullable();
                $table->timestamps();

                /*$table->foreign('vehicle_id')->references('id')->on('vehicles')
                    ->onUpdate('cascade')->onDelete('cascade');*/
            });

            Schema::create('field_states', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('state_id')->unsigned();
                $table->integer('field_id')->unsigned();
                $table->timestamps();

               /* $table->foreign('state_id')->references('id')->on('states')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('field_id')->references('id')->on('fields')
                    ->onUpdate('cascade')->onDelete('cascade');*/
            });


            Schema::create('processes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('reference')->unique();
                $table->integer('state_id')->unsigned();
                $table->timestamps();

                /*$table->foreign('state_id')->references('id')->on('states')
                    ->onUpdate('cascade')->onDelete('cascade');*/
            });



            Schema::create('services', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('description')->nullable();
                $table->timestamps();
            });



            Schema::create('employees', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('phone');
                $table->string('address')->nullable();
                $table->integer('service_id')->unsigned();
                $table->timestamps();

            });


            Schema::create('diagnostics', function (Blueprint $table) {
                $table->increments('id');
                $table->string('reference')->unique();
                $table->integer('vehicle_id')->unsigned();
                $table->integer('process_id')->unsigned();
                $table->integer('prestation')->unsigned();
                $table->integer('state');
                $table->timestamps();

               /* $table->foreign('vehicle_id')->references('id')->on('vehicles')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('process_id')->references('id')->on('process')
                    ->onUpdate('cascade')->onDelete('cascade');*/
            });


            Schema::create('before_tests', function (Blueprint $table) {
                $table->increments('id');
                $table->string('description')->nullable();
                $table->integer('employee_id')->unsigned();
                $table->integer('process_id')->unsigned();
                $table->timestamps();

               /* $table->foreign('process_id')->references('id')->on('process')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('employee_id')->references('id')->on('employees')
                    ->onUpdate('cascade')->onDelete('cascade');*/
            });


            Schema::create('after_tests', function (Blueprint $table) {
                $table->increments('id');
                $table->string('observation')->nullable();
                $table->integer('diagnostic_id')->unsigned();
                $table->timestamps();

               /* $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                    ->onUpdate('cascade')->onDelete('cascade');*/
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
