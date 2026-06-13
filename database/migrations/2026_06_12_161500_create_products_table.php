<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Als een categorie wordt verwijderd (soft delete), blokkeren we hard deletes
            // of laten we de producten bestaan (aangezien de categorie soft-deleted is).
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->text('description');
            
            // Decimal is verplicht voor financiële transacties
            $table->decimal('price', 10, 2);
            
            $table->string('badge')->nullable()->index(); // Bijv. 'Nieuw', 'Sale'
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false);
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
