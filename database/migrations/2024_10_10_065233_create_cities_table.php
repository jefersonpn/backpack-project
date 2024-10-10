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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code_ibge')->nullable()->unique();
            $table->string('code_istat')->nullable()->unique();
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
