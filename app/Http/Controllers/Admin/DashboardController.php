<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Totale Omzet (alleen van betaalde en verzonden orders)
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped'])->sum('total_price');

        // 2. Aantal Bestellingen (alleen betaald en verzonden)
        $totalOrders = Order::whereIn('status', ['paid', 'shipped'])->count();

        // 3. Aantal Producten
        $totalProducts = Product::count();

        // 4. Aantal Klanten (gebruikers die geen admin zijn)
        $totalCustomers = User::where('role', 'klant')->count();

        // 5. Recente Bestellingen (laatste 5 stuks, verberg onbetaalde/verlaten winkelwagens)
        $recentOrders = Order::with('user')
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders'
        ));
    }
}
