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
            $table->string('name');           // Owner of the tenant
            $table->string('lastname');       // Owner's last name
            $table->string('email')->unique();  // Tenant's email
            $table->foreignId('address_id')->constrained('addresses')->nullable(); // Address id
            $table->json('phones');       // Phones
            $table->string('logo')->nullable();  // Tenant's logo
            $table->string('cnpj')->nullable();  // Tenant's CNPJ
            $table->string('iva')->nullable();  // Tenant's IVA
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
