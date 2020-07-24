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
            $table->bigInteger('listing_id')->unsigned()->nullable();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->string('title');
            $table->decimal('price', 20, 2);
            $table->decimal('local_price', 20, 2);
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
