<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('sys_modules', function (Blueprint $table) {
        //    $table->string('id',50)->primary();
        //    $table->string('name',50);
        //    $table->string('description')->nullable();
        //    $table->integer('sequence');
        //    $table->string('icon',50);
        //    $table->tinyInteger('enabled')->default('0')->nullable();
        //    $table->tinyInteger('foundation')->nullable();
        //    $table->timestamps();
        //});

        //Schema::create('sys_menus', function (Blueprint $table) {
        //    $table->string('id', 50)->primary();
        //    $table->string('parent_id', 50)->nullable();
        //    $table->string('name', 50);
        //    $table->text('description')->nullable();
        //    $table->string('route', 50)->nullable();
        //    $table->string('sequence', 50);
        //    $table->string('icon', 50);
        //    $table->tinyInteger('enabled')->default('0')->nullable();
        //    $table->string('shown', 50)->nullable();
        //    $table->timestamps();
        //});

        //Schema::create('sys_admins', function (Blueprint $table) {
		//	$table->string('id', 50)->primary();
		//	$table->string('name', 50);
		//	$table->string('email', 50)->unique();
		//	$table->string('password', 255);
		//	$table->string('phone_number', 13)->unique();
		//	$table->string('gender', 10);
		//	$table->string('image', 255)->nullable();
        //    $table->text('address')->nullable();    
        //    $table->tinyInteger('enabled')->default('0')->nullable();
        //    $table->string('remember_token', 100)->nullable();
		//	$table->timestamps();
        //});
        
        //Schema::create('sys_roles', function (Blueprint $table) {
        //    $table->string('id', 50)->primary();
        //    $table->string('name',50);
        //    $table->text('description')->nullable();
        //    $table->tinyInteger('enabled')->default(0)->nullable();
        //    $table->timestamps();
        //});

        //Schema::create('sys_admin_roles', function (Blueprint $table) {
        //    $table->string('id', 50)->primary();
        //    $table->string('role_id', 50);
        //    $table->foreign('role_id')->references('id')->on('sys_roles');
        //    $table->string('admin_id', 50);
        //    $table->foreign('admin_id')->references('id')->on('sys_admins');
        //    $table->string('enabled', 50);
        //    $table->timestamps();
        //});

        //Schema::create('sys_permissions', function (Blueprint $table) {
        //    $table->string('id',50)->primary();
        //    $table->string('role_id',50);
        //    $table->foreign('role_id')->references('id')->on('sys_roles');
        //    $table->string('module_id',50);
        //    $table->foreign('module_id')->references('id')->on('sys_modules');
        //    $table->string('menu_id',50);
        //    $table->foreign('menu_id')->references('id')->on('sys_menus');
        //    $table->tinyInteger('allow_create')->nullable();
        //    $table->tinyInteger('allow_read')->nullable();
        //    $table->tinyInteger('allow_delete')->nullable();
        //    $table->tinyInteger('allow_update')->nullable();
        //    $table->timestamps();
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('sys_menus');
        //Schema::dropIfExists('sys_modules');
        //Schema::dropIfExists('sys_admins');
        //Schema::dropIfExists('sys_roles');
        //Schema::dropIfExists('sys_admin_roles');
        //Schema::dropIfExists('sys_permissions');
    }
}
