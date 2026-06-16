<?php

namespace App\Actions\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class ProcessCheckoutAction
{
    /**
     * Slaat een bestelling op en genereert een Stripe betalingslink
     */
    public function execute(array $validatedData, array $cartItems, float $totalPrice): string
    {
        // 1. Maak de order aan in de database (als pending)
        $order = DB::transaction(function () use ($validatedData, $cartItems, $totalPrice) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . date('Y') . '-' . strtoupper(uniqid()),
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'zipcode' => $validatedData['zipcode'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'product_name' => $item['name'],
                    'variant_name' => $item['variant_name'],
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['unit_price'] * $item['quantity'],
                ]);
            }

            return $order;
        });

        // 2. Setup Stripe
        Stripe::setApiKey(env('STRIPE_SECRET', 'sk_test_fake_secret_for_now'));

        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'] . ($item['variant_name'] ? ' (' . $item['variant_name'] . ')' : ''),
                    ],
                    'unit_amount' => (int) round($item['unit_price'] * 100), // in cents
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card', 'ideal'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
            'customer_email' => $validatedData['email'],
        ]);

        // Sla de Stripe sessie ID op in de order
        $order->update(['stripe_session_id' => $checkoutSession->id]);

        return $checkoutSession->url;
    }
}
