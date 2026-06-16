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
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 sticky top-28 shadow-2xl">
                    <!-- Search Bar -->
                    <form action="{{ route('shop.index') }}" method="GET" class="mb-8">
                        @if(request()->has('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Zoek naar loot..." class="w-full bg-[#0A0A0A]/50 backdrop-blur-md border border-white/10 rounded-xl pl-4 pr-10 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#ff2a42]/50 focus:ring-1 focus:ring-[#ff2a42]/50 transition-colors font-medium">
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
                            <li>
                                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                                   class="group flex items-center justify-between p-3 rounded-xl transition-all {{ request('category') === $category->slug ? 'bg-[#ff2a42]/10 text-[#ff2a42] border border-[#ff2a42]/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                                    <span class="font-bold text-sm uppercase tracking-wider">{{ $category->name }}</span>
                                    @if(request('category') === $category->slug)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    @endif
                                </a>
                                @if($category->children->count() > 0)
                                    <ul class="mt-2 ml-4 space-y-1 border-l-2 border-white/5 pl-4">
                                        @foreach($category->children as $child)
                                            <li>
                                                <a href="{{ route('shop.index', ['category' => $child->slug]) }}" class="block p-2 rounded-lg font-semibold text-xs uppercase tracking-wider transition-colors {{ request('category') === $child->slug ? 'text-[#ff2a42]' : 'text-gray-500 hover:text-gray-300' }}">
                                                    {{ $child->name }}
                                                </a>
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
                <!-- Info Bar -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-10 gap-4">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">
                        @if(request('category'))
                            {{ request('category') }} <span class="text-gray-600 font-medium tracking-normal text-lg lowercase">({{ $products->total() }} resultaten)</span>
                        @else
                            Discover All <span class="text-gray-600 font-medium tracking-normal text-lg lowercase">({{ $products->total() }} items)</span>
                        @endif
                    </h3>
                </div>

                @if($products->isEmpty())
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-16 text-center shadow-2xl">
                        <div class="w-24 h-24 mx-auto bg-black rounded-full flex items-center justify-center mb-6 border border-white/5">
                            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-3 uppercase tracking-wider">Geen Loot Gevonden</h3>
                        <p class="text-gray-400 font-medium">De kluis is leeg voor deze categorie. Zoek verder!</p>
                        <a href="{{ route('shop.index') }}" class="inline-block mt-8 px-8 py-3 bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-widest rounded-lg transition-colors border border-white/10">
                            Reset Filters
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($products as $product)
                            <a href="{{ route('shop.show', $product->slug) }}" class="group relative bg-black border border-white/10 rounded-2xl overflow-hidden hover:border-[#ff2a42]/50 transition-all duration-500 hover:shadow-[0_0_30px_rgba(255,42,66,0.15)] flex flex-col hover:-translate-y-1">
                                
                                <!-- Image Container -->
                                <div class="relative aspect-[4/5] overflow-hidden bg-[#0a0a0a]">
                                    @if($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-800 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
                                            <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif

                                    <!-- Overlay Gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-500"></div>

                                    <!-- Badges -->
                                    <div class="absolute top-4 left-4 flex flex-col gap-2 z-20">
                                        @if($product->is_featured)
                                            <span class="bg-[#ff2a42] text-white text-[10px] font-black px-3 py-1.5 rounded uppercase tracking-[0.2em] shadow-[0_0_15px_rgba(255,42,66,0.5)]">
                                                Hot Drop
                                            </span>
                                        @endif
                                        @if($product->badge)
                                            <span class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black px-3 py-1.5 rounded uppercase tracking-[0.2em]">
                                                {{ $product->badge }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Hover Overlay Action -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                                        <span class="bg-[#ff2a42]/90 backdrop-blur-sm text-white font-black text-xs py-3 px-6 rounded-full uppercase tracking-widest shadow-[0_0_30px_rgba(255,42,66,0.5)] transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                            Bekijken
                                        </span>
                                    </div>
                                </div>

                                <!-- Info Container -->
                                <div class="p-6 relative z-10 bg-black flex-1 flex flex-col">
                                    <p class="text-[#ff2a42] text-[10px] font-black uppercase tracking-[0.2em] mb-2">{{ $product->category->name }}</p>
                                    <h3 class="text-xl font-bold text-white mb-4 line-clamp-2 leading-tight group-hover:text-[#ff2a42] transition-colors flex-1">{{ $product->name }}</h3>
                                    
                                    <div class="flex items-end justify-between mt-auto">
                                        <p class="text-2xl font-black text-white">&euro; {{ number_format($product->price, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Pagination -->
                <div class="mt-16">
                    {{ $products->links() }}
                </div>
            </div>
            
        </div>
    </div>
</x-shop-layout>
