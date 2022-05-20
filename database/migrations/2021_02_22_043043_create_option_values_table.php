<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->bigInteger('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->tinyInteger('preview_config')->default(1);
            $table->tinyInteger('color_config')->default(1);
            $table->string('color')->nullable();
            $table->longText('html')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('option_values');
    }
}
