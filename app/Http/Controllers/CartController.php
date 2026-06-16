<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function index()
    {
        $cartItems = $this->cartService->getCart();
        $total = $this->cartService->getTotal();
        
        return view('shop.cart', compact('cartItems', 'total'));
    }

    public function add(\App\Http\Requests\Shop\CartAddRequest $request, Product $product)
    {
        $validated = $request->validated();

        $this->cartService->add($product, $validated['variant_id'] ?? null, $validated['quantity']);

        return redirect()->route('cart.index')
                         ->with('success', 'Product toegevoegd aan je winkelwagen!');
    }

    public function update(\App\Http\Requests\Shop\CartUpdateRequest $request, string $itemKey)
    {
        $validated = $request->validated();

        $this->cartService->update($itemKey, $validated['quantity']);

        return redirect()->route('cart.index')
                         ->with('success', 'Winkelwagen bijgewerkt!');
    }

    public function remove(string $itemKey)
    {
        $this->cartService->remove($itemKey);

        return redirect()->route('cart.index')
                         ->with('success', 'Product verwijderd uit winkelwagen.');
    }
}
