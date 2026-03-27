<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProducts');
            $table->unsignedBigInteger('idSuppliers');
            $table->string('batch_code', 50); // Código do lote do fabricante
            $table->date('manufacturing_date')->nullable();
            $table->date('expiration_date');
            $table->integer('quantity'); // Quantidade total de entrada
            $table->integer('quantity_now'); // Quantidade atual em stock
            $table->decimal('cost_price', 10, 2); // Preço de custo pago ao fornecedor
            $table->timestamps();
            $table->softDeletes();

            // Chaves Estrangeiras
            $table->foreign('idProducts')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('idSuppliers')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};