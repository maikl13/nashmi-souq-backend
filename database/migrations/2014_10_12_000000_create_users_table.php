<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->string('password');
            $table->tinyInteger('role_id')->default(1);
            $table->boolean('active')->default(true);
            $table->string('profile_picture')->nullable();

            //store details
            $table->string('store_name')->nullable();
            $table->string('store_slogan')->nullable();
            $table->string('store_website')->nullable();
            $table->string('store_email')->nullable();
            $table->text('store_address')->nullable();
            $table->text('store_description')->nullable();
            $table->text('store_social_accounts')->nullable();
            $table->text('store_banner')->nullable();
            $table->text('store_logo')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
