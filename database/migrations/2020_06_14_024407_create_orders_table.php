<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('buyer_name');
            $table->decimal('price', 20, 2);
            $table->bigInteger('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->decimal('taxes', 20, 2);
            $table->decimal('fees', 20, 2);
            $table->decimal('shipping', 20, 2)->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('restrict');
            $table->string('phone');
            $table->string('address');
            $table->string('shipping_method');
            $table->string('payment_method');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('orders');
    }
}
