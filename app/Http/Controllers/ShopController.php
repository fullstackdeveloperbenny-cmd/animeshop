<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Toont het productoverzicht (de catalogus).
     * Handelt filtering (categorieën), zoekopdrachten (Live Search), en paginering af.
     * Optimaliseert database queries via Eager Loading om N+1 problemen te voorkomen.
     *
     * @param Request $request De inkomende HTTP-aanvraag, inclusief eventuele zoek- en filterparameters
     * @return \Illuminate\View\View|string Retouneert een volledige View, of een HTML string bij een AJAX request
     */
    public function index(Request $request)
    {
        // Start met een query voor alleen actieve producten
        // We 'eager load' direct category en primaryImage om performance (N+1 probleem) te voorkomen
        $query = Product::active()
                        ->whereHas('category')
                        ->with(['category', 'primaryImage']);

        // Als er gefilterd wordt op categorie
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                // Haal de ID van deze categorie op, plus de ID's van alle onderliggende (sub)categorieën
                $categoryIds = $category->children()->pluck('id')->push($category->id);
                
                // Filter de producten zodat ze in deze categorie OF in een van de subcategorieën vallen
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Als er gefilterd wordt op zoekterm
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // We zetten 'featured' producten bovenaan, en daarna sorteren we op de nieuwste (latest)
        $products = $query->orderByDesc('is_featured')
                          ->latest()
                          ->paginate(12)
                          ->withQueryString();
        
        // Haal ook de categorieën op voor in de sidebar navigatie
        // We laden de 'children' alvast in voor subcategorieën (mochten we die in de UI willen tonen)
        $categories = Category::active()
                              ->whereNull('parent_id')
                              ->with('children.children')
                              ->get();

        // AJAX Request? Stuur alleen de HTML van het product-grid terug (voor Live Search)
        if ($request->ajax()) {
            return view('shop.partials._product-grid', compact('products'))->render();
        }

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Toont de detailpagina van één specifiek product.
     * Laadt tevens gerelateerde producten (upselling) en relaties (afbeeldingen, varianten).
     *
     * @param Product $product Het automatisch gebonden product-model (Route Model Binding)
     * @return \Illuminate\View\View
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException Wanneer product inactief is
     */
    public function show(Product $product)
    {
        // Bescherming: Als de beheerder het product inactief heeft gemaakt, gooi een 404 (Not Found)
        // Of als de categorie van dit product in de prullenbak zit
        if (!$product->is_active || !$product->category) {
            abort(404);
        }

        // Laad alle nodige relaties in
        $product->load(['category', 'images', 'variants']);
        
        // Zorg dat primary image altijd makkelijk bereikbaar is, of pak gewoon de eerste als fallback
        $primaryImage = $product->primaryImage ?? $product->images->first();

        // Haal gerelateerde producten op uit dezelfde categorie (om klanten langer op de site te houden)
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->with('primaryImage')
            ->get();

        return view('shop.show', compact('product', 'primaryImage', 'relatedProducts'));
    }
}
