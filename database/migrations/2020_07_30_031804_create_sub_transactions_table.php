<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id')->unsigned()->index();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->decimal('amount_usd', 20, 4)->nullable();
            $table->decimal('amount', 20, 4)->nullable();
            $table->bigInteger('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->decimal('original_amount', 20, 4)->nullable();
            $table->bigInteger('original_currency_id')->unsigned();
            $table->foreign('original_currency_id')->references('id')->on('currencies')->onDelete('cascade');
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
        Schema::dropIfExists('sub_transactions');
    }
}
