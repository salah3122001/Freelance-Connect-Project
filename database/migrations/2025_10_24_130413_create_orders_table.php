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

            $table->decimal('amount', 10, 2);
            
            $table->string('payment_id')->nullable();
            $table->timestamps();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('freelance_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete()->cascadeOnUpdate();

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
