<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Products\CreateProductAction;
use App\Actions\Products\UpdateProductAction;
use App\Actions\Products\RestoreProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variants'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request, CreateProductAction $action)
    {
        $action->handle($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product succesvol aangemaakt.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load(['images', 'variants']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product, UpdateProductAction $action)
    {
        $action->handle($product, $request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product succesvol bijgewerkt.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product succesvol verwijderd (naar prullenbak).');
    }

    public function trash()
    {
        // Enkel producten ophalen die soft-deleted zijn
        $trashedProducts = Product::onlyTrashed()->with(['category', 'variants'])->latest('deleted_at')->paginate(10);
        return view('admin.products.trash', compact('trashedProducts'));
    }

    public function restore(Product $product, RestoreProductAction $action)
    {
        $action->handle($product);

        return redirect()
            ->route('admin.products.trash')
            ->with('success', 'Product succesvol hersteld.');
    }
}
