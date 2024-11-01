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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('ragione_sociale')->nullable();
            $table->string('name')->nullable();
            $table->foreignId('address_id')->constrained('addresses')->nullable();
            $table->json('doctors')->nullable();
            $table->string('logo')->nullable();
            $table->string('header_img')->nullable();
            $table->json('colors')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('iva')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
