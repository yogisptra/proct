<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Master Data Migrations
        Schema::create('dns_banks', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('image', 100)->nullable();
            $table->tinyInteger('enabled')->default('0')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('dns_bank_accounts', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->foreign('bank_id')->references('id')->on('dns_banks');
            $table->string('bank_id', 50);
            $table->string('type', 100);
            $table->string('account_name', 150);
            $table->string('account_number', 100)->nullable();
            $table->tinyInteger('enabled')->default('0')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('dns_sliders', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
            $table->string('link', 100)->nullable();
            $table->string('image', 100);
            $table->text('description')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->tinyInteger('enabled')->default('0')->nullable();
            $table->timestamps();
        });

        Schema::create('dns_categories', function (Blueprint $table) {
            $table->string('id',50)->primary();
            $table->string('name',50);
            $table->text('description')->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('sequence', 250)->nullable();
            $table->tinyInteger('enabled')->default('0')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('dns_faq_categories', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 255);
			$table->text('description');
            $table->tinyInteger('enabled')->default('0')->nullable();
			$table->string('created_by', 100)->nullable();
			$table->string('updated_by', 100)->nullable();
			$table->timestamps();
        });

        Schema::create('dns_faq_descriptions', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->foreign('faq_categories_id')->references('id')->on('dns_faq_categories');
            $table->string('faq_categories_id', 50);
            $table->string('type', 100);
            $table->string('question', 255);
            $table->text('answer');
            $table->string('keyword', 100);
            $table->tinyInteger('enabled')->default('0')->nullable();
			$table->string('created_by', 100)->nullable();
			$table->string('updated_by', 100)->nullable();
			$table->timestamps();
        });

        Schema::create('dns_contact_us', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('subject', 100);
            $table->text('message');
			$table->timestamps();
        });

        Schema::create('dns_manual_confirmations', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            // $table->foreign('user_id')->references('id')->on('dns_users');
            // $table->string('user_id', 50);
            // $table->foreign('transaction_id')->references('id')->on('dns_transactions');
            $table->string('transaction_number', 50);
            $table->string('bank_account_id', 50);
            $table->string('image', 50);
            $table->dateTime('confirmation_date');
            $table->string('amount', 50);
			$table->timestamps();
        });

        Schema::create('dns_widhdrawals', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('user_id', 100)->nullable();
            $table->string('campaign_id', 100)->nullable();
            $table->string('bank_account_id', 100)->nullable();
            $table->string('request_date', 100)->nullable();
            $table->string('amount', 100)->nullable();
            $table->string('percentage', 100)->nullable();
            $table->string('total_amount', 100)->nullable();
            $table->date('approval_date')->nullable();
            $table->string('status', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('dns_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('donatur_id', 100)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('sys_transaction_types', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
			$table->text('description');
            $table->tinyInteger('enabled')->default('0')->nullable();
			$table->string('created_by', 100)->nullable();
			$table->string('updated_by', 100)->nullable();
			$table->timestamps();
        });

        Schema::create('sys_transaction_details', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('type_transaction_id', 100)->nullable();
            $table->string('name', 100);
			$table->text('description');
            $table->tinyInteger('enabled')->default('0')->nullable();
			$table->string('created_by', 100)->nullable();
			$table->string('updated_by', 100)->nullable();
			$table->timestamps();
        });

        Schema::create('sys_countries', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
            $table->tinyInteger('enabled')->default('0')->nullable();
        });

        Schema::create('sys_provinces', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('country_id', 100);
            $table->string('name', 100);
            $table->tinyInteger('enabled')->default('0')->nullable();
        });

        Schema::create('sys_cities', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('country_id', 100);
            $table->string('province_id', 100);
            $table->string('name', 100);
            $table->tinyInteger('enabled')->default('0')->nullable();
        });

        Schema::create('sys_districts', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('country_id', 100);
            $table->string('province_id', 100);
            $table->string('city_id', 100);
            $table->string('name', 100);
            $table->tinyInteger('enabled')->default('0')->nullable();
        });

        Schema::create('sys_areas', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('country_id', 100);
            $table->string('province_id', 100);
            $table->string('city_id', 100);
            $table->string('district_id', 100);
            $table->string('name', 100);
            $table->tinyInteger('enabled')->default('0')->nullable();
        });

        Schema::create('sys_profile_instations', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->text('website')->nullable();
            $table->text('address')->nullable();
            $table->text('email')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('social_media')->nullable();
			$table->string('created_by', 100)->nullable();
			$table->string('updated_by', 100)->nullable();
			$table->timestamps();
        });

        Schema::create('dns_campaigns', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            // $table->foreign('categories_id')->references('id')->on('dns _categories');
            $table->string('categories_id', 50);
            $table->string('user_id', 50)->nullable();
            $table->string('title', 150);
            $table->string('target', 100)->nullable();
            // $table->string('minimal_amount', 255)->nullable();
            $table->text('custom_amount')->nullable();
            $table->date('valid_date')->nullable();
            $table->tinyInteger('open_goal')->default('0')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 100)->nullable();
            $table->string('background', 100)->nullable();
            $table->text('slug')->nullable();
            $table->tinyInteger('main_program')->default('0')->nullable();
            $table->tinyInteger('enabled')->default('0')->nullable();
            $table->string('fb_pixel',255)->nullable();
            $table->string('gtm', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('dns_campaign_updates', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->foreign('campaign_id')->references('id')->on('dns_campaigns');
            $table->string('campaign_id', 50);
            $table->string('title', 150);
            $table->text('content');
            $table->tinyInteger('enabled')->default('0')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('sys_notification_logs', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('subject', 50);
            $table->string('type', 150);
            $table->text('description');
            $table->string('object_id', 150);
            $table->tinyInteger('is_read')->default('0')->nullable();
            $table->string('to')->nullable();
            $table->string('from')->nullable();
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
        Schema::dropIfExists('dns_banks');
        Schema::dropIfExists('dns_bank_accounts');
        Schema::dropIfExists('dns_sliders');
        Schema::dropIfExists('dns_categories');
        Schema::dropIfExists('dns_faq_categories');
        Schema::dropIfExists('dns_contact_us');
        Schema::dropIfExists('dns_manual_confirmations');
        Schema::dropIfExists('dns_campaigns');
        Schema::dropIfExists('dns_campaign_updates');
        Schema::dropIfExists('dns_widhdrawals');
        // Schema::dropIfExists('dns_likes');
        Schema::dropIfExists('sys_transaction_types');
        Schema::dropIfExists('sys_transaction_details');
        Schema::dropIfExists('sys_countries');
        Schema::dropIfExists('sys_provinces');
        Schema::dropIfExists('sys_cities');
        Schema::dropIfExists('sys_districts');
        Schema::dropIfExists('sys_areas');
        Schema::dropIfExists('sys_profile_instations');
        Schema::dropIfExists('sys_notification_logs');
    }
}
