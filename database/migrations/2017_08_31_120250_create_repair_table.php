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

        Schema::create('works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->enum('state',['1','0','4']);
            $table->integer('distance');
            $table->string('place');
            $table->string('description');
            $table->integer('diagnostic_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('site_id')->unsigned();
            $table->timestamps();

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
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
            //0 = finish, 1 = begin, 2 = demand, 3 = demand accepted, 4 = repair return, 5 = output
            $table->enum('state', ['0', '1', '2', '3', '4','5']);
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

        Schema::create('service_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->string('title');
            $table->text('description');
            $table->integer('diagnostic_id');
            $table->timestamps();

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('service_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->integer('diagnostic_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->timestamps();

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->text('remark')->nullable();
            $table->integer('diagnostic_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('site_id')->unsigned();
            $table->timestamps();

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
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
