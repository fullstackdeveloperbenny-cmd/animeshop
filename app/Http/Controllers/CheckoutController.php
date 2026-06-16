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

    public function process(\App\Http\Requests\Shop\CheckoutProcessRequest $request, \App\Actions\Orders\ProcessCheckoutAction $processCheckoutAction)
    {
        $cartItems = $this->cartService->getCart();
        
        if (empty($cartItems)) {
            return redirect()->route('shop.index');
        }

        $validated = $request->validated();
        $total = $this->cartService->getTotal();

        try {
            $checkoutUrl = $processCheckoutAction->execute($validated, $cartItems, $total);
            return redirect($checkoutUrl);
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

            // Verstuur de bevestigingsmail naar de klant
            \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderPaidMail($order));
        }

        return view('shop.checkout-success', compact('order'));
    }

    public function cancel(Order $order)
    {
        return redirect()->route('cart.index')->with('error', 'Betaling geannuleerd. Probeer het opnieuw.');
    }
}
