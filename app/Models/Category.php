<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * De attributen die mass assignable zijn.
     */
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'is_active',
    ];

    /**
     * De attributen die gecast moeten worden.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Haal de subcategorieën op.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Haal de hoofdcategorie op.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Haal de producten in deze categorie op.
     * (Model Product volgt in Fase 5)
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope voor alleen actieve categorieën.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
