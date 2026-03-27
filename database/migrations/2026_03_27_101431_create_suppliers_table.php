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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); // Sugiro usar 'id' padrão do Laravel para facilitar relações
            $table->string('company_name'); // Razão Social
            $table->string('trade_name')->nullable(); // Nome Fantasia
            $table->string('cnpj', 14)->unique(); // Apenas números
            $table->string('contact_name')->nullable();
            $table->string('phone', 11); // Apenas números
            $table->string('state_registration')->nullable(); // Inscrição Estadual
            $table->string('email')->unique();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
            $table->softDeletes(); // Importante para histórico de compras
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
