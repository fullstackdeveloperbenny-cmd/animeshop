                <!-- Info Bar -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-10 gap-4">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">
                        @if(request('category'))
                            {{ request('category') }} <span class="text-gray-600 font-medium tracking-normal text-lg lowercase">({{ $products->total() }} resultaten)</span>
                        @elseif(request('search'))
                            Zoekresultaten <span class="text-gray-600 font-medium tracking-normal text-lg lowercase">({{ $products->total() }} items)</span>
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
                        <p class="text-gray-400 font-medium">De kluis is leeg voor deze categorie of zoekterm. Zoek verder!</p>
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
                                            <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
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
                                    <p class="text-[#ff2a42] text-[10px] font-black uppercase tracking-[0.2em] mb-2">{{ $product->category?->name ?? 'Zonder categorie' }}</p>
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
