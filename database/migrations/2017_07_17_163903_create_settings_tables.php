<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('shelves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ray_id');
            $table->string('name');
            $table->timestamps();


             $table->foreign('ray_id')->references('id')->on('rays')
                 ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shelf_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('shelf_id')->references('id')->on('shelves')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('brand_id')->unsigned();
            $table->timestamps();

             $table->foreign('brand_id')->references('id')->on('brands')
                 ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });


        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('category_id')->unsinged();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
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
        //
    }
}
