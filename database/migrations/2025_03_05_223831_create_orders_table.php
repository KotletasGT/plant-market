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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'cancelled', 'paid'])->default('pending');
            $table->string('address');
            $table->integer('quantity')->default(1);
            $table->decimal('price_per_item', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
            $table->enum('payment', ['unpaid', 'paid'])->default('unpaid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
