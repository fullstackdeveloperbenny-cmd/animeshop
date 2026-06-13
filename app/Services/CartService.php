<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Session;

class CartService
{
    private string $sessionKey = 'shopping_cart';

    /**
     * Haal alle items op uit de sessie
     */
    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Voeg een product (met evt variant) toe aan de wagen
     */
    public function add(Product $product, ?int $variantId, int $quantity = 1): void
    {
        $cart = $this->getCart();
        
        // Genereer een unieke sleutel voor dit item in de wagen.
        // Als het een variant heeft, maken we onderscheid tussen bijv maat S en L van hetzelfde shirt.
        $itemKey = $product->id . ($variantId ? '_' . $variantId : '');

        if (array_key_exists($itemKey, $cart)) {
            // Als het al in de wagen zit, verhoog de hoeveelheid
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            // Voeg nieuw toe
            $priceModifier = 0;
            $variantName = null;

            if ($variantId) {
                $variant = Variant::find($variantId);
                if ($variant && $variant->product_id === $product->id) {
                    $priceModifier = $variant->price_modifier;
                    $variantName = $variant->type . ': ' . $variant->value;
                }
            }

            $cart[$itemKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image_path' => $product->primaryImage ? $product->primaryImage->path : null,
                'variant_id' => $variantId,
                'variant_name' => $variantName,
                'base_price' => (float)$product->price,
                'price_modifier' => (float)$priceModifier,
                'unit_price' => (float)$product->price + (float)$priceModifier,
                'quantity' => $quantity,
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    /**
     * Pas de hoeveelheid van een item aan (meer/minder)
     */
    public function update(string $itemKey, int $quantity): void
    {
        $cart = $this->getCart();

        if (array_key_exists($itemKey, $cart)) {
            if ($quantity <= 0) {
                $this->remove($itemKey);
            } else {
                $cart[$itemKey]['quantity'] = $quantity;
                Session::put($this->sessionKey, $cart);
            }
        }
    }

    /**
     * Verwijder een item uit de wagen
     */
    public function remove(string $itemKey): void
    {
        $cart = $this->getCart();

        if (array_key_exists($itemKey, $cart)) {
            unset($cart[$itemKey]);
            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Bereken de totale prijs van de winkelwagen
     */
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getCart() as $item) {
            $total += $item['unit_price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Bereken het totaal aantal fysieke items (voor het badge icoontje)
     */
    public function getCount(): int
    {
        $count = 0;
        foreach ($this->getCart() as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    
    /**
     * Leeg de winkelwagen (na afrekenen)
     */
    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
