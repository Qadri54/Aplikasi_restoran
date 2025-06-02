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
        Schema::create('orders', callback: function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->foreignId('table_id')->constrained(
                'tables','id','fk_table_order'
            );
            $table->foreignId('user_id')->constrained(
                'users','id','fk_user_order'
            );
            // $table->string('order_code')->unique();
            $table->timestamps();
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
