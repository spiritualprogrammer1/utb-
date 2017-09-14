<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->integer('bus_id')->unsigned();
            $table->text('incident')->unique();
            $table->text('remarque');
            $table->integer('kilometer');
            $table->enum('state', ['0', '1']);
            $table->integer('site_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('bus_id')->references('id')->on('buses')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('field_states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->integer('state_id')->unsigned();
            $table->text('field_id')->unique();
            $table->integer('site_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('field_id')->references('id')->on('fields')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('diagnostics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->string('reference')->unique();
            $table->integer('state_id');
            $table->enum('active', ['0', '1', '2']);
            $table->enum('type', ['0', '1', '2', '3']);
            $table->integer('user_id')->unsigned();
            $table->integer('site_id')->unsigned();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('before_works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->integer('distance');
            $table->string('place');
            $table->string('description');
            $table->string('process_id');
            $table->integer('process_id');
            $table->integer('employee_id');
            $table->integer('user_id');
            $table->timestamps();

            $table->foreign('process_id')->references('id')->on('processes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('after_works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->enum('type', ['0','4']);
            $table->integer('distance');
            $table->string('place');
            $table->string('description');
            $table->string('process_id');
            $table->integer('process_id');
            $table->integer('employee_id');
            $table->integer('user_id');
            $table->timestamps();

            $table->foreign('process_id')->references('id')->on('processes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('diagnostic_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->integer('diagnostic_id');
            $table->integer('employee_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->integer('diagnostic_id');
            $table->enum('state', ['0', '1', '2', '3', '4']);
            $table->integer('site_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('repairs_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->string('title');
            $table->text('description');
            $table->integer('repair_id');
            $table->timestamps();

            $table->foreign('repair_id')->references('id')->on('repairs')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('repair_technician', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->integer('repair_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->timestamps();

            $table->foreign('repair_id')->references('id')->on('repairs')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('employee_id')->references('id')->on('employees')
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
