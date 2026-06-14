<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            // Stripe payment info
            $table->string('stripe_session_id')->nullable();
            
            // Order details
            $table->string('order_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('address');
            $table->string('city');
            $table->string('zipcode');
            
            // Pricing
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // pending, paid, shipped, cancelled
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
