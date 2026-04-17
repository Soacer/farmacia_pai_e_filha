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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();            
            
            $table->foreignUuid('idCategory')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            
            $table->string('name', 255);
            $table->longText('description')->nullable();
            $table->string('barcode', 13)->unique()->nullable();
            $table->string('active_principle', 255)->nullable();
            
            $table->boolean('isActive')->default(true);
            $table->boolean('requires_prescription')->default(false);
            
            $table->decimal('price', 10, 2);
            
            $table->integer('min_stock_alert')->default(5);

            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
