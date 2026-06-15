<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AnimaShop') }}</title>

    <!-- Google Fonts: Outfit voor een supermoderne, strakke look -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,600,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        /* Custom scrollbar voor dark mode */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #ff2a42; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d91c30; }
        /* Neon text glow */
        .neon-text { text-shadow: 0 0 10px rgba(255,42,66,0.5); }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-[#0a0a0a] via-[#111111] to-black text-gray-200 min-h-screen flex flex-col selection:bg-[#ff2a42] selection:text-white">
    
    <!-- Navbar (Glassmorphism) -->
    <nav class="sticky top-0 z-50 bg-black/60 backdrop-blur-xl border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10 flex items-center justify-center">
                        <div class="absolute inset-0 bg-[#ff2a42] rounded-xl transform rotate-45 group-hover:rotate-90 transition-transform duration-500 shadow-[0_0_20px_rgba(255,42,66,0.4)]"></div>
                        <svg class="relative w-5 h-5 text-white z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-2xl font-black tracking-widest text-white uppercase ml-2">
                        Anima<span class="text-[#ff2a42] neon-text">Shop</span>
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex items-center gap-8">
                    <a href="{{ route('shop.index') }}" class="text-sm font-bold {{ request()->routeIs('shop.*') && !request()->routeIs('cart.*') ? 'text-[#ff2a42]' : 'text-gray-300 hover:text-white hover:text-[#ff2a42]' }} uppercase tracking-widest transition-colors">Catalogus</a>
                    <a href="{{ route('pages.about') }}" class="text-sm font-bold {{ request()->routeIs('pages.about') ? 'text-[#ff2a42]' : 'text-gray-300 hover:text-white hover:text-[#ff2a42]' }} uppercase tracking-widest transition-colors">Over Ons</a>
                    <a href="{{ route('pages.contact') }}" class="text-sm font-bold {{ request()->routeIs('pages.contact') ? 'text-[#ff2a42]' : 'text-gray-300 hover:text-white hover:text-[#ff2a42]' }} uppercase tracking-widest transition-colors">Contact</a>
                    
                    <div class="flex items-center gap-6 border-l border-white/10 pl-8 ml-4">
                        <!-- Winkelwagen Icoon -->
                        @php
                            $cartCount = app(\App\Services\CartService::class)->getCount();
                        @endphp
                        <a href="{{ route('cart.index') }}" class="relative text-gray-300 hover:text-[#ff2a42] transition-colors group">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-[#ff2a42] text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full shadow-[0_0_10px_rgba(255,42,66,0.8)] group-hover:scale-110 transition-transform">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        @if (Route::has('login'))
                            @auth
                                @if(auth()->user()->role->value === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-lg border border-[#ff2a42] text-[#ff2a42] font-bold text-xs uppercase tracking-widest hover:bg-[#ff2a42] hover:text-white transition-all shadow-[0_0_15px_rgba(255,42,66,0.2)]">Admin</a>
                                @else
                                    <a href="{{ route('customer.profile') }}" class="text-sm font-bold text-gray-300 hover:text-white uppercase tracking-widest transition-colors">Mijn Profiel</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-400 hover:text-white uppercase tracking-widest transition-colors">Inloggen</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-sm font-bold text-gray-400 hover:text-[#ff2a42] uppercase tracking-widest transition-colors">Registreren</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-white/10 bg-black/50 backdrop-blur-md pt-16 pb-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12 border-b border-white/10 pb-12">
                
                <div>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-[#ff2a42] rounded-lg transform rotate-45 flex items-center justify-center shadow-[0_0_15px_rgba(255,42,66,0.3)]"></div>
                        <span class="text-xl font-black tracking-widest uppercase text-white">Anima<span class="text-[#ff2a42]">Shop</span></span>
                    </a>
                    <p class="text-gray-400 text-sm font-medium leading-relaxed">De #1 bestemming voor authentieke Anime merchandise, streetwear en collectibles in de Benelux.</p>
                </div>

                <div>
                    <h3 class="text-white font-black uppercase tracking-[0.2em] mb-6">Navigatie</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Catalogus</a></li>
                        <li><a href="{{ route('pages.about') }}" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Over Ons</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-black uppercase tracking-[0.2em] mb-6">Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Algemene Voorwaarden</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Privacybeleid</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Retourbeleid</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm font-semibold tracking-wider">&copy; {{ date('Y') }} AnimaShop. Gemaakt voor de échte fans.</p>
                <div class="flex gap-4">
                    <!-- Social placeholders -->
                    <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#ff2a42] transition-all cursor-pointer"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></div>
                    <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#ff2a42] transition-all cursor-pointer"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
