<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

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

    public function add(Product $product, ?int $variantId, int $quantity = 1): void
    {
        $cart = $this->getCart();
        
        // Genereer een unieke sleutel voor dit item in de wagen.
        $itemKey = $product->id . ($variantId ? '_' . $variantId : '');

        // Controleer voorraad
        $variantName = null;
        $priceModifier = 0;

        if ($variantId) {
            $variant = Variant::find($variantId);
            if (!$variant) {
                throw ValidationException::withMessages(['quantity' => 'Variant niet gevonden.']);
            }

            $currentCartQty = isset($cart[$itemKey]) ? $cart[$itemKey]['quantity'] : 0;
            $newTotalQty = $currentCartQty + $quantity;

            if ($newTotalQty > $variant->stock) {
                $maxToOrder = $variant->stock - $currentCartQty;
                if ($maxToOrder > 0) {
                    $msg = "Je kan er nog max {$maxToOrder} toevoegen voor de moment tot de stock weer is aangevuld. Mvg!";
                } else {
                    $msg = "Je hebt de maximale voorraad ({$variant->stock} stuks) al in je winkelwagen zitten. Voor de moment kan je er niet meer bestellen tot de stock weer is aangevuld. Mvg!";
                }
                
                throw ValidationException::withMessages([
                    'quantity' => $msg
                ]);
            }

            $priceModifier = $variant->price_modifier;
            $variantName = $variant->type . ': ' . $variant->value;
        }

        if (array_key_exists($itemKey, $cart)) {
            // Als het al in de wagen zit, verhoog de hoeveelheid
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            // Voeg nieuw toe
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
                $variantId = $cart[$itemKey]['variant_id'];
                if ($variantId) {
                    $variant = Variant::find($variantId);
                    if ($variant && $quantity > $variant->stock) {
                        throw ValidationException::withMessages([
                            'quantity' => "Je kan er maar max {$variant->stock} bestellen voor de moment tot de stock weer is aangevuld. Mvg!"
                        ]);
                    }
                }

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
