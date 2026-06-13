<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AnimaShop') }} - Admin</title>

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Inter'] antialiased bg-gray-100 text-[#0A0A0A] flex h-screen overflow-hidden">

    <!-- Sidebar Wrapper -->
    <div class="w-64 flex flex-col h-screen shrink-0">
        <!-- Logo Area (Witte achtergrond zoals foto 2) -->
        <div class="h-16 flex items-center px-6 bg-white border-b border-r border-gray-200">
            <span class="text-xl font-black uppercase tracking-wider text-[#0A0A0A]">
                Anima<span class="text-[#E8192C]">Shop</span>
            </span>
        </div>

        <!-- Sidebar Content -->
        <aside class="flex-1 bg-gray-800 flex flex-col">
            <nav class="flex-1 py-4 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-3 text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white border-l-4 border-[#E8192C]' : 'text-gray-300 hover:text-white hover:bg-gray-700 border-l-4 border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-6 py-3 text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('admin.categories.*') ? 'bg-gray-900 text-white border-l-4 border-[#E8192C]' : 'text-gray-300 hover:text-white hover:bg-gray-700 border-l-4 border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Categorieën
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center px-6 py-3 text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('admin.products.*') ? 'bg-gray-900 text-white border-l-4 border-[#E8192C]' : 'text-gray-300 hover:text-white hover:bg-gray-700 border-l-4 border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Producten
                </a>
                
                <!-- Toekomstige navigatie -->
            </nav>
        </aside>
    </div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Top Header (Witte achtergrond zoals foto 2) -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0">
            <div class="flex items-center">
                <!-- Hamburger Menu Icoon Placeholder -->
                <button class="text-gray-500 hover:text-[#0A0A0A] focus:outline-none mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-black uppercase text-[#0A0A0A]">
                    {{ $header ?? 'Dashboard' }}
                </h1>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-200 flex items-center justify-center text-xs font-bold text-[#0A0A0A] uppercase">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <span class="text-sm font-semibold text-[#0A0A0A]">{{ Auth::user()->name }}</span>
                </div>
                
                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="border-l border-gray-200 pl-6">
                    @csrf
                    <button type="submit" class="text-sm font-bold uppercase text-gray-500 hover:text-[#E8192C]">
                        Uitloggen
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            {{ $slot }}
        </main>

    </div>

</body>
</html>
