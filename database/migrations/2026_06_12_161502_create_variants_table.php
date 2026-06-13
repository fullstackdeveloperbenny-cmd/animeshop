<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            $table->string('type');         // bijv: 'maat', 'schaal', 'kleur'
            $table->string('value');        // bijv: 'M', 'L', '1/7'
            
            // Voorraad mag nooit onder 0 gaan
            $table->unsignedInteger('stock')->default(0)->index();
            
            // Eventuele meerprijs of korting voor deze specifieke variant
            $table->decimal('price_modifier', 10, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
