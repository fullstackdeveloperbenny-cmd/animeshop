<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Products\CreateProductAction;
use App\Actions\Products\SoftDeleteProductAction;
use App\Actions\Products\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Product::class);
        $products = Product::with(['category', 'primaryImage'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        Gate::authorize('create', Product::class);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request, CreateProductAction $action)
    {
        $action->handle($request->validated());
        return redirect()->route('admin.products.index')->with('success', 'Product succesvol aangemaakt met foto\'s en varianten.');
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $product->load(['variants', 'images']);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product, UpdateProductAction $action)
    {
        $action->handle($product, $request->validated());
        return redirect()->route('admin.products.index')->with('success', 'Product succesvol bijgewerkt.');
    }

    public function destroy(Product $product, SoftDeleteProductAction $action)
    {
        Gate::authorize('delete', $product);
        $action->handle($product);
        return redirect()->route('admin.products.index')->with('success', 'Product verwijderd via Soft Delete.');
    }
}
