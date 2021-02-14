<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_listings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('listing_id')->unsigned();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->decimal('price', 20, 2);
            $table->bigInteger('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
            $table->bigInteger('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->tinyInteger('tier');
            $table->datetime('expired_at');
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
        Schema::dropIfExists('featured_listings');
    }
}
