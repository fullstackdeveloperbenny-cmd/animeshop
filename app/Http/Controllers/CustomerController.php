<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        
        // Haal de bestellingen van deze gebruiker op, nieuwste eerst. 
        // We verbergen 'pending' (verlaten winkelwagens) voor de klant.
        $orders = Order::where('user_id', $user->id)
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('shop.profile', compact('user', 'orders'));
    }

    public function order(Order $order)
    {
        // Check of de order wel van de ingelogde gebruiker is!
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Je hebt geen toegang tot deze bestelling.');
        }

        $order->load('items');
        
        return view('shop.order-detail', compact('order'));
    }
}
