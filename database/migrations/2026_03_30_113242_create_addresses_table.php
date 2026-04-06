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
        Schema::create('addresses', function (Blueprint $table) {
        $table->id();

        // 1:N - Um cliente pode aparecer em várias linhas desta tabela
        $table->foreignId('idCustomer')->nullable()->constrained('customers')->onDelete('cascade');
        $table->foreignId('idSupplier')->nullable()->constrained('suppliers')->onDelete('cascade');

        // 1:1 - O 'unique()' garante que um idEmployee só apareça uma vez na tabela toda
        $table->foreignId('idEmployee')->unique()->nullable()->constrained('employees')->onDelete('cascade');

        $table->string('zip_code', 8);
        $table->string('street');
        $table->string('number', 10);
        $table->string('complement')->nullable();
        $table->string('neighborhood');
        $table->string('city')->default('Salvador');
        $table->char('state', 2)->default('BA');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
