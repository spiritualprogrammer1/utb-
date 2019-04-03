<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iso');
            $table->string('name');
            $table->string('nicename');
            $table->string('iso3');
            $table->integer('numcode')->unique();
            $table->integer('phonecode')->unsigned();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->string('name');
            $table->string('rccm')->nullable();
            $table->string('phone')->unique();
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->enum('type', array('0', '1'));
            $table->integer('country_id')->unsigned();
            $table->string('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->string('number');
            $table->string('order');
            $table->integer('amount');
            $table->integer('supplier_id')->unsigned();
            $table->text('image')->nullable();
            $table->date('delivery_at');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->string('name');
            $table->string('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->string('name');
            $table->integer('brand_id')->unsigned();
            $table->string('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->string('reference')->unique();
            $table->integer('delivery_id')->unsinged();
            $table->integer('model_id')->unsinged();
            $table->integer('supplier_id')->unsinged();
            $table->integer('sub_category_id')->unsinged();
            $table->integer('type_id')->unsinged();
            $table->integer('block_id')->unsinged();
            $table->integer('guaranty')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('deliveries')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('model_id')->references('id')->on('models')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('sub_category_id')->references('id')->on('sub_categories')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('type_id')->references('id')->on('types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('block_id')->references('id')->on('blocks')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('movement_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->string('reference')->unique();
            $table->string('demand_id')->nullable();
            $table->integer('delivery_id')->unsigned();
            $table->enum('type', array('0', '1','2','3'));
            $table->integer('user_id')->unsigned();
            $table->timestamps();

           $table->foreign('delivery_id')->references('id')->on('deliveries')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('demand_id')->references('id')->on('demands')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('demands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->string('reference')->unique();
            $table->integer('diagnostic_id')->unsigned();
            $table->enum('state', ['0','1','2']);
            $table->timestamps();

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('demand_pieces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->string('piece');
            $table->integer('quantity');
            $table->enum('state',['0','1']);
            $table->integer('demand_id');
            $table->timestamps();

            $table->foreign('demand_id')->references('id')->on('demands')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('item_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ids')->unique();
            $table->integer('stock_id')->unsigned();
            $table->integer('movement_stock_id')->unsigned();
            $table->integer('quantity');
            $table->integer('quantity_old');
            $table->timestamps();

            $table->foreign('movement_stock_id')->references('id')->on('movement_stock')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ids')->unique();
            $table->string('reference')->unique();
            $table->integer('demand_id')->unsigned();
            $table->integer('site_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('demand_id')->references('id')->on('demands')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('site_id')->references('id')->on('sites')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
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

    }
}
