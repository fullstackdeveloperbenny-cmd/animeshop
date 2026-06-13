<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Toont het productoverzicht (de catalogus).
     */
    public function index(Request $request)
    {
        // Start met een query voor alleen actieve producten
        // We 'eager load' direct category en primaryImage om performance (N+1 probleem) te voorkomen
        $query = Product::where('is_active', true)
                        ->with(['category', 'primaryImage']);

        // Als er gefilterd wordt op categorie
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                // Filter de producten op de id van deze categorie
                $query->where('category_id', $category->id);
            }
        }

        // We zetten 'featured' producten bovenaan, en daarna sorteren we op de nieuwste (latest)
        $products = $query->orderByDesc('is_featured')
                          ->latest()
                          ->paginate(12);
        
        // Haal ook de categorieën op voor in de sidebar navigatie
        // We laden de 'children' alvast in voor subcategorieën (mochten we die in de UI willen tonen)
        $categories = Category::active()
                              ->whereNull('parent_id')
                              ->with('children')
                              ->get();

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Toont de detailpagina van één specifiek product.
     */
    public function show(Product $product)
    {
        // Bescherming: Als de beheerder het product inactief heeft gemaakt, gooi een 404 (Not Found)
        if (!$product->is_active) {
            abort(404);
        }

        // Laad alle nodige relaties in
        $product->load(['category', 'images', 'variants']);
        
        // Zorg dat primary image altijd makkelijk bereikbaar is, of pak gewoon de eerste als fallback
        $primaryImage = $product->primaryImage ?? $product->images->first();

        // Haal gerelateerde producten op uit dezelfde categorie (om klanten langer op de site te houden)
        $relatedProducts = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->with('primaryImage')
            ->get();

        return view('shop.show', compact('product', 'primaryImage', 'relatedProducts'));
    }
}
