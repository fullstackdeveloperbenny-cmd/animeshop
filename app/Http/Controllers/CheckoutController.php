<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Http\Requests\Shop\CheckoutProcessRequest;
use App\Actions\Orders\ProcessCheckoutAction;
use App\Models\Variant;
use App\Mail\OrderPaidMail;
use Exception;

class CheckoutController extends Controller
{
    /**
     * Dependency Injection van de CartService om winkelwagen-logica herbruikbaar te maken.
     */
    public function __construct(private CartService $cartService) {}

    /**
     * Toont de afreken-pagina.
     * Verwijst de gebruiker terug naar de shop als de winkelwagen leeg is.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $cartItems = $this->cartService->getCart();
        
        if (empty($cartItems)) {
            return redirect()->route('shop.index')->with('error', 'Je winkelwagen is leeg!');
        }

        $total = $this->cartService->getTotal();

        return view('shop.checkout', compact('cartItems', 'total'));
    }

    /**
     * Verwerkt de formulier-inzending van de checkout.
     * Valideert de input, maakt de order aan via een Action class,
     * en stuurt de klant door naar de externe Stripe betaalpagina.
     *
     * @param CheckoutProcessRequest $request Bevat alle validatie-regels voor het adres
     * @param ProcessCheckoutAction $processCheckoutAction Zware database/API logica geïsoleerd in een Action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(CheckoutProcessRequest $request, ProcessCheckoutAction $processCheckoutAction)
    {
        // 1. Zorg dat we altijd actuele voorraad hebben vóór betaling (Race Condition fix!)
        $warnings = $this->cartService->validateCartStock();
        
        if (!empty($warnings)) {
            return redirect()->route('cart.index')->with('error', 'De voorraad van een of meerdere producten is tussentijds gewijzigd. Je winkelwagen is automatisch aangepast.');
        }

        $cartItems = $this->cartService->getCart();
        
        if (empty($cartItems)) {
            return redirect()->route('shop.index');
        }

        $validated = $request->validated();
        $total = $this->cartService->getTotal();

        try {
            $checkoutUrl = $processCheckoutAction->execute($validated, $cartItems, $total);
            return redirect($checkoutUrl);
        } catch (Exception $e) {
            // Failsafe if Stripe is not configured properly in .env yet
            return back()->with('error', 'Fout bij verbinden met betaalprovider. Is de STRIPE_SECRET ingesteld?');
        }
    }

    /**
     * Wordt aangeroepen wanneer Stripe de klant succesvol terugstuurt.
     * Markeert de order als betaald, haalt items uit voorraad, en verstuurt de mail.
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function success(Request $request, Order $order)
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'paid']);
            
            // Voorraad (Stock) verminderen
            foreach ($order->items as $item) {
                if ($item->variant_id) {
                    Variant::where('id', $item->variant_id)->decrement('stock', $item->quantity);
                }
            }

            // Leeg de winkelwagen
            $this->cartService->clear();

            // Verstuur de bevestigingsmail naar de klant
            Mail::to($order->email)->send(new OrderPaidMail($order));
        }

        return view('shop.checkout-success', compact('order'));
    }

    /**
     * Wordt aangeroepen als de klant de betaling op Stripe annuleert.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Order $order)
    {
        return redirect()->route('cart.index')->with('error', 'Betaling geannuleerd. Probeer het opnieuw.');
    }
}
