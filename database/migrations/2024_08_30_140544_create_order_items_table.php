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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Foreign Key ke tabel orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign Key ke tabel products
            $table->integer('quantity'); // Jumlah produk yang dipesan
            $table->decimal('price', 15, 2); // Harga produk per lembar saat dipesan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
