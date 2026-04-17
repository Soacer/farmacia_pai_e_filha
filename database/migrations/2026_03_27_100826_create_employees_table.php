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
            $table->uuid('id')->primary();            

            // Forma moderna e mais segura de referenciar chaves estrangeiras:
            $table->foreignUuid('idUsers')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignUuid('idOccupations')
                ->constrained('occupations'); 

            $table->string('cpf', 11)->unique();
            $table->string('rg', 15)->nullable();
            $table->string('phone', 11);
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F', 'Outro'])->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('hire_date')->nullable();
            $table->date('resignation_date')->nullable();
            $table->string('pis', 11)->nullable();
            $table->string('ctps', 20)->nullable();
            $table->string('crf', 15)->nullable();
            $table->boolean('isActive')->default(true);

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
