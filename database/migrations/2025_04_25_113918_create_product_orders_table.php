<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_product')
                ->constrained('products')
                ->onDelete('cascade');

            $table->foreignId('id_order')
                ->constrained('orders')
                ->onDelete('cascade');

            // $table->string('order_code');
            // $table->foreign('order_code')
            //     ->references('order_code')
            //     ->on('orders')
                // ->onDelete('cascade');
            $table->integer('quanity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('prdouct_orders');
    }
};
