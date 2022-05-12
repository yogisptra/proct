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
            $table->string('id', 50)->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
			$table->string('phone_number', 50)->unique()->nullable();
			$table->string('gender', 10)->nullable();
			$table->string('image', 255)->nullable();
            $table->text('address')->nullable();    
            $table->tinyInteger('enabled')->default('0')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('dns_donaturs', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('nik', 25)->nullable()->unique();
            $table->string('name', 100);
            $table->string('email', 100)->nullable()->unique();
            $table->string('password', 100)->nullable();
            $table->string('phone_number', 25)->nullable()->unique();
            $table->string('gender', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->string('country_id', 50)->nullable();
            $table->string('province_id', 50)->nullable();
            $table->string('city_id', 50)->nullable();
            $table->string('district_id', 50)->nullable();
            $table->string('area_id', 50)->nullable();
            $table->string('codepos', 10)->nullable();
            $table->text('address')->nullable();
            $table->string('religion', 50)->nullable();
            $table->text('bio')->nullable();
            $table->string('nationality', 50)->nullable();
            $table->text('domicile', 50)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('is_campaigner', 50)->nullable();
            $table->string('type_campaigner', 100)->nullable();
            $table->string('image_ktp', 100)->nullable();
            $table->string('image_selfie', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('linkedin', 100)->nullable();
            $table->string('tiktok', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('slug_token', 10)->nullable();
            $table->string('api_token', 255);
            $table->string('otp', 10)->nullable();
            $table->string('remember_token', 255);
            $table->tinyInteger('email_verified')->default('0')->nullable();
            $table->tinyInteger('activated')->default('0')->nullable();
            $table->timestamps();
        });

        Schema::create('dns_donaturs-oauth', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('donatur_id', 50)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('provider', 50)->nullable();
            $table->string('provider_uid', 255)->nullable();
            $table->string('access_token', 255)->nullable();
            $table->string('refresh_token', 255)->nullable();
            $table->tinyInteger('activated')->default('0')->nullable();
            $table->timestamps();
        });

        Schema::create('dns_corporate_details', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('nib', 100)->nullable();
            $table->string('type_corporate', 100)->nullable();
            $table->string('user_id', 100)->nullable();
            $table->string('corporate_name', 100)->nullable();
            $table->string('corporate_email', 100)->nullable();
            $table->string('corporate_phone_number', 15)->nullable();
            $table->text('corporate_address')->nullable();
            $table->string('corporate_country', 100)->nullable();
            $table->string('corporate_province', 100)->nullable();
            $table->string('corporate_city', 100)->nullable();
            $table->string('corporate_district', 100)->nullable();
            $table->string('corporate_area', 100)->nullable();
            $table->string('corporate_codepos', 100)->nullable();
            $table->text('bio')->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('tiktok', 100)->nullable();
            $table->string('linkedin', 100)->nullable();
            $table->string('file_akta', 100)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('nik_pic', 100)->unique()->nullable();
            $table->string('name_pic', 100)->nullable();
            $table->string('email_pic', 100)->nullable();
            $table->string('phone_number_pic', 15)->nullable();
            $table->string('ktp_pic', 100)->nullable();
            $table->string('image_selfie_pic', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('dns_bank_account_campaigners', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('bank_id', 100)->nullable();
            $table->string('user_id', 100)->nullable();
            $table->string('account_number', 100)->nullable();
            $table->string('account_name', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('dns_transactions', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('campaign_id', 50)->nullable();
            $table->string('type_transaction_id', 50)->nullable();
            $table->string('donatur_id', 50)->nullable();
            $table->string('bank_account_id', 50)->nullable();
            $table->string('donation_type', 100)->nullable();
            $table->string('fundraiser_id', 50)->nullable();
            $table->string('transaction_number', 150);
            $table->datetime('transaction_date')->nullable();
            $table->datetime('payment_date')->nullable();
            $table->string('transaction_status_id', 100);
            $table->string('unique_code', 50)->nullable();
            $table->double('amount', 100);
            $table->string('payment_method', 100);
            $table->text('note')->nullable();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone_number', 15);
            $table->string('transaction_via', 100);
            $table->string('image', 100)->nullable();
            $table->tinyInteger('is_hamba_allah')->default('0')->nullable();
            $table->string('is_delete', 10)->nullable();
            $table->dateTime('expired_date')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
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
        Schema::dropIfExists('dns_donaturs');
        Schema::dropIfExists('dns_donaturs-oauth');
        Schema::dropIfExists('dns_user_details');
        Schema::dropIfExists('dns_bank_account_campaigners');
        Schema::dropIfExists('dns_transactions');
    }
}
