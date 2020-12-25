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
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->string('phone_national')->unique();
            $table->string('phone_country_code');
            $table->string('otp')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('role_id')->default(1);
            $table->boolean('active')->default(true);
            $table->string('profile_picture')->nullable();
            $table->text('address')->nullable();
            $table->text('shipping_address')->nullable();

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
            $table->timestamp('trial_started_at')->nullable();

            // payout_methods
            $table->string('bank_account')->nullable();
            $table->string('paypal')->nullable();
            $table->string('vodafone_cash')->nullable();
            $table->string('national_id')->nullable();

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
