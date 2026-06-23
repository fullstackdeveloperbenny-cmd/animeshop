<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="AnimaShop is de #1 webshop voor authentieke Anime merchandise, streetwear, Manga's en Collectibles in de Benelux.">
    <meta name="keywords" content="Anime, Manga, Nendoroid, Funko Pop, Streetwear, Webshop, Cosplay">
    <meta name="author" content="AnimaShop Team">
    <meta name="robots" content="index, follow">

    <title>{{ config('app.name', 'AnimaShop') }}</title>

    <!-- Google Fonts: Outfit voor een supermoderne, strakke look -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,600,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

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
                    <ul class="space-y-4">
                        <li><a href="{{ route('pages.terms') }}" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Algemene Voorwaarden</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Privacybeleid</a></li>
                        <li><a href="{{ route('pages.returns') }}" class="text-gray-400 hover:text-[#ff2a42] text-sm font-medium transition-colors">Retourbeleid</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm font-semibold tracking-wider">&copy; {{ date('Y') }} AnimaShop. Gemaakt voor de échte fans.</p>
            </div>
        </div>
    </footer>
</body>
</html>
