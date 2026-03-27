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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('idUsers'); // FK para a tabela users
        $table->string('cpf', 11)->unique();
        $table->string('phone', 11);
        $table->date('birth_date');
        $table->decimal('salary', 10, 2)->nullable(); // Salário
        $table->date('hire_date')->nullable();        // Data de admissão
        $table->string('pis', 11)->nullable();        // PIS/PASEP
        $table->string('job_title')->nullable();      // Cargo (ex: Farmacêutico, Balconista)
        $table->boolean('isActive')->default(true);
        
        $table->foreign('idUsers')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
