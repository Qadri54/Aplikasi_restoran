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
        Schema::create('order_item_take_aways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order_take_away')
                ->constrained('order_take_aways')
                ->onDelete('cascade');
            
            $table->foreignId('id_product')
                ->constrained('products')
                ->onDelete('cascade');

            $table->integer('quanity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_take_aways');
    }
};
