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
            $table->string('name')->nullable();           // Owner of the tenant
            $table->string('lastname')->nullable();       // Owner's last name
            $table->string('email')->unique()->nullable();  // Tenant's email
            $table->json('phones')->nullable();        // Tenant's phones
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete(); // Address id
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->nullOnDelete(); // Clinic id            $table->json('phones')->nullable();  // Phones
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
