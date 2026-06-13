<x-shop-layout>
    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute top-0 left-0 w-[800px] h-[800px] bg-[#ff2a42]/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="mb-12">
            <h1 class="text-4xl sm:text-5xl font-black text-white uppercase tracking-widest mb-4">Mijn Loot</h1>
            <p class="text-gray-400">Jouw huidige selectie epische anime merchandise.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-400 px-6 py-4 rounded-xl mb-8 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(empty($cartItems))
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-12 rounded-3xl text-center shadow-2xl">
                <svg class="w-24 h-24 text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <h2 class="text-2xl font-black text-white mb-4 uppercase tracking-widest">Je winkelwagen is leeg</h2>
                <p class="text-gray-400 mb-8">Tijd om wat epische loot te verzamelen!</p>
                <a href="{{ route('shop.index') }}" class="inline-block bg-[#ff2a42] hover:bg-[#d91c30] text-white font-black py-4 px-8 rounded-xl transition-all uppercase tracking-widest">Terug naar de Shop</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Cart Items -->
                <div class="lg:col-span-8 space-y-6">
                    @foreach($cartItems as $key => $item)
                        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl flex flex-col sm:flex-row gap-6 relative group">
                            <!-- Image -->
                            <div class="w-32 h-32 bg-black/50 rounded-2xl overflow-hidden flex-shrink-0 border border-white/5">
                                @if($item['image_path'])
                                    <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-700">Geen foto</div>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-black text-white uppercase tracking-wider">
                                            <a href="{{ route('shop.show', $item['slug']) }}" class="hover:text-[#ff2a42] transition-colors">{{ $item['name'] }}</a>
                                        </h3>
                                        <!-- Remove Button -->
                                        <form action="{{ route('cart.remove', $key) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-[#ff2a42] transition-colors p-2" title="Verwijderen">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    @if($item['variant_name'])
                                        <p class="text-sm text-[#ff2a42] font-bold uppercase tracking-widest mb-1">{{ $item['variant_name'] }}</p>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <p class="text-2xl font-black text-white">
                                        <span class="text-gray-500 text-lg">&euro;</span> {{ number_format($item['unit_price'], 2, ',', '.') }}
                                    </p>
                                    
                                    <!-- Quantity Update Form -->
                                    <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center bg-black/50 border border-white/10 rounded-xl overflow-hidden">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-4 py-2 text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                                        </button>
                                        <input type="number" value="{{ $item['quantity'] }}" readonly class="w-12 text-center bg-transparent border-none text-white font-bold focus:ring-0 p-0 text-sm">
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-4 py-2 text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total Box -->
                <div class="lg:col-span-4">
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl sticky top-28 shadow-2xl">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4">Overzicht</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-gray-400 font-bold">
                                <span>Subtotaal</span>
                                <span>&euro; {{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400 font-bold">
                                <span>Verzendkosten</span>
                                <span class="text-green-400">Gratis</span>
                            </div>
                            <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                                <span class="text-white font-black uppercase tracking-widest">Totaal</span>
                                <span class="text-3xl font-black text-[#ff2a42]">
                                    <span class="text-xl text-gray-500">&euro;</span> {{ number_format($total, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button disabled class="w-full bg-[#ff2a42]/50 text-white font-black py-5 px-8 rounded-xl transition-all uppercase tracking-[0.2em] flex items-center justify-center gap-4 cursor-not-allowed mb-4">
                            Afrekenen (Fase 8)
                        </button>
                        
                        <a href="{{ route('shop.index') }}" class="w-full bg-transparent border border-white/10 hover:border-white/30 text-gray-400 hover:text-white font-bold py-4 px-8 rounded-xl transition-all uppercase tracking-widest flex items-center justify-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Verder Winkelen
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-shop-layout>
