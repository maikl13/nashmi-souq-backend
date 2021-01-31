<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('title');
            $table->decimal('price', 20, 2);
            // The price in the original currency
            $table->decimal('original_price', 20, 2);
            $table->bigInteger('original_currency_id')->unsigned()->nullable();
            $table->foreign('original_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->integer('quantity');
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
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
        Schema::dropIfExists('package_items');
    }
}
