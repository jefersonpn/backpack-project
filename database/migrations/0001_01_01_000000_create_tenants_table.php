<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();  // Domain to identify the tenant
            $table->string('db_name');           // Tenant's database name
            $table->string('db_host')->default('mysql-backpack'); // Database host
            $table->string('db_user');           // Database username
            $table->string('db_password');       // Database password
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
