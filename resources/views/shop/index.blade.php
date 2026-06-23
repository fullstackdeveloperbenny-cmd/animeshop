<x-shop-layout>
    
    <!-- Hero Banner with Parallax-ish Effect -->
    <div class="relative overflow-hidden bg-black border-b border-white/10 h-[40vh] min-h-[300px] flex items-center justify-center">
        <!-- Abstract glowing background -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[300px] bg-[#ff2a42]/20 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30 mix-blend-overlay"></div>
        
        <div class="relative z-10 text-center px-4 flex flex-col items-center">
            <span class="px-4 py-1.5 rounded-full border border-[#ff2a42]/50 text-[#ff2a42] text-xs font-black uppercase tracking-[0.3em] mb-6 backdrop-blur-sm shadow-[0_0_15px_rgba(255,42,66,0.2)]">New Collection Drop</span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white uppercase tracking-tight mb-6 drop-shadow-2xl">
                Level Up Your <br/><span class="text-[#ff2a42] neon-text">Anime Arsenal</span>
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Sidebar: Categories (Glassmorphism) -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 sticky top-28 shadow-2xl max-h-[calc(100vh-8rem)] overflow-y-auto custom-scrollbar">
                    <!-- Search Bar -->
                    <form action="{{ route('shop.index') }}" method="GET" class="mb-8">
                        @if(request()->has('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative">
                            <input type="text" id="liveSearchInput" name="search" value="{{ request('search') }}" placeholder="Zoek naar loot..." autocomplete="off" class="w-full bg-[#0A0A0A]/50 backdrop-blur-md border border-white/10 rounded-xl pl-4 pr-10 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#ff2a42]/50 focus:ring-1 focus:ring-[#ff2a42]/50 transition-colors font-medium">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-[#ff2a42] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                    </form>

                    <h2 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-[#ff2a42] shadow-[0_0_10px_rgba(255,42,66,0.8)]"></span>
                        Categorieën
                    </h2>
                    
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop.index') }}" class="group flex items-center justify-between p-3 rounded-xl transition-all {{ !request()->has('category') ? 'bg-[#ff2a42]/10 text-[#ff2a42] border border-[#ff2a42]/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                                <span class="font-bold text-sm uppercase tracking-wider">Alle Items</span>
                                @if(!request()->has('category'))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                @endif
                            </a>
                        </li>
                        @foreach($categories as $category)
                            @php
                                $isActive = request('category') === $category->slug;
                                $hasActiveChild = $category->children->contains('slug', request('category'));
                                $isOpen = $isActive || $hasActiveChild;
                            @endphp
                            <li x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }">
                                <div class="flex items-center justify-between group rounded-xl transition-all {{ $isActive ? 'bg-[#ff2a42]/10 border border-[#ff2a42]/20' : 'hover:bg-white/5' }}">
                                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                                       class="flex-1 p-3 font-bold text-sm uppercase tracking-wider {{ $isActive ? 'text-[#ff2a42]' : 'text-gray-300 group-hover:text-white' }}">
                                        {{ $category->name }}
                                    </a>
                                    @if($category->children->count() > 0)
                                        <button @click.prevent="open = !open" class="p-3 text-gray-500 hover:text-white focus:outline-none transition-transform duration-300" :class="{'rotate-180': open}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                    @endif
                                </div>
                                @if($category->children->count() > 0)
                                    <ul x-show="open" 
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 -translate-y-2"
                                        class="mt-2 ml-4 space-y-1 border-l-2 border-white/5 pl-4" style="display: {{ $isOpen ? 'block' : 'none' }};">
                                        @foreach($category->children as $child)
                                            @php
                                                $isChildActive = request('category') === $child->slug;
                                                $hasActiveSubChild = $child->children->contains('slug', request('category'));
                                                $isChildOpen = $isChildActive || $hasActiveSubChild;
                                            @endphp
                                            <li x-data="{ openChild: {{ $isChildOpen ? 'true' : 'false' }} }">
                                                <div class="flex items-center justify-between group">
                                                    <a href="{{ route('shop.index', ['category' => $child->slug]) }}" class="block p-2 rounded-lg font-semibold text-xs uppercase tracking-wider transition-colors {{ $isChildActive ? 'text-[#ff2a42]' : 'text-gray-500 hover:text-gray-300' }}">
                                                        {{ $child->name }}
                                                    </a>
                                                    @if($child->children->count() > 0)
                                                        <button @click.prevent="openChild = !openChild" class="p-2 text-gray-600 hover:text-white transition-transform" :class="{'rotate-180': openChild}">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                @if($child->children->count() > 0)
                                                    <ul x-show="openChild" class="ml-3 pl-3 border-l border-white/5 space-y-1 mt-1" style="display: {{ $isChildOpen ? 'block' : 'none' }};">
                                                        @foreach($child->children as $subchild)
                                                            <li>
                                                                <a href="{{ route('shop.index', ['category' => $subchild->slug]) }}" class="block p-1.5 rounded text-[10px] uppercase tracking-widest {{ request('category') === $subchild->slug ? 'text-[#ff2a42]' : 'text-gray-600 hover:text-gray-400' }}">
                                                                    {{ $subchild->name }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <div id="productGridContainer" class="relative transition-opacity duration-300">
                    @include('shop.partials._product-grid')
                </div>
            </div>
            
        </div>
    </div>
</x-shop-layout>
