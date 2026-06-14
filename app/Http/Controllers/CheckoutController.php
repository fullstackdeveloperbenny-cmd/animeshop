<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index()
    {
        $cartItems = $this->cartService->getCart();
        
        if (empty($cartItems)) {
            return redirect()->route('shop.index')->with('error', 'Je winkelwagen is leeg!');
        }

        $total = $this->cartService->getTotal();

        return view('shop.checkout', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $cartItems = $this->cartService->getCart();
        
        if (empty($cartItems)) {
            return redirect()->route('shop.index');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
        ]);

        $total = $this->cartService->getTotal();

        // 1. Maak de order aan in de database (als pending)
        $order = DB::transaction(function () use ($validated, $cartItems, $total) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . date('Y') . '-' . strtoupper(uniqid()),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'zipcode' => $validated['zipcode'],
                'total_price' => $total,
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

        try {
            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card', 'ideal'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
                'customer_email' => $validated['email'],
            ]);

            // Sla de Stripe sessie ID op in de order
            $order->update(['stripe_session_id' => $checkoutSession->id]);

            return redirect($checkoutSession->url);
        } catch (\Exception $e) {
            // Failsafe if Stripe is not configured properly in .env yet
            return back()->with('error', 'Fout bij verbinden met betaalprovider. Is de STRIPE_SECRET ingesteld?');
        }
    }

    public function success(Request $request, Order $order)
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'paid']);
            // Leeg de winkelwagen
            $this->cartService->clear();
        }

        return view('shop.checkout-success', compact('order'));
    }

    public function cancel(Order $order)
    {
        return redirect()->route('cart.index')->with('error', 'Betaling geannuleerd. Probeer het opnieuw.');
    }
}
