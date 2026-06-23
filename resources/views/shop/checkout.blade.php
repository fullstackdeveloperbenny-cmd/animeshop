<x-shop-layout>
    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-[#ff2a42]/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="mb-12">
            <h1 class="text-4xl sm:text-5xl font-black text-white uppercase tracking-widest mb-4">Afrekenen</h1>
            <p class="text-gray-400">Vul je gegevens in om de bestelling af te ronden.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-400 px-6 py-4 rounded-xl mb-8 font-bold">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/20 border border-red-500/50 text-red-400 px-6 py-4 rounded-xl mb-8 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            @csrf
            
            <!-- Left Column: Form -->
            <div class="lg:col-span-7 space-y-8">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
                    <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6 relative z-10">Jouw Gegevens</h3>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6 relative z-10">
                        <div>
                            <x-input-label for="first_name" value="Voornaam" class="text-gray-400 uppercase tracking-widest text-xs font-black mb-2" />
                            <x-text-input id="first_name" name="first_name" type="text" class="w-full bg-black/50 border-white/10 focus:border-[#ff2a42] text-white" value="{{ old('first_name') }}" required autofocus />
                        </div>
                        <div>
                            <x-input-label for="last_name" value="Achternaam" class="text-gray-400 uppercase tracking-widest text-xs font-black mb-2" />
                            <x-text-input id="last_name" name="last_name" type="text" class="w-full bg-black/50 border-white/10 focus:border-[#ff2a42] text-white" value="{{ old('last_name') }}" required />
                        </div>
                    </div>

                    <div class="mb-6 relative z-10">
                        <x-input-label for="email" value="E-mailadres" class="text-gray-400 uppercase tracking-widest text-xs font-black mb-2" />
                        <x-text-input id="email" name="email" type="email" class="w-full bg-black/50 border-white/10 focus:border-[#ff2a42] text-white" value="{{ old('email', auth()->user()->email ?? '') }}" required />
                    </div>

                    <div class="mb-6 relative z-10">
                        <x-input-label for="address" value="Straat en Huisnummer" class="text-gray-400 uppercase tracking-widest text-xs font-black mb-2" />
                        <x-text-input id="address" name="address" type="text" class="w-full bg-black/50 border-white/10 focus:border-[#ff2a42] text-white" value="{{ old('address', auth()->user()->address ?? '') }}" required />
                    </div>

                    <div class="grid grid-cols-2 gap-6 relative z-10">
                        <div>
                            <x-input-label for="zipcode" value="Postcode" class="text-gray-400 uppercase tracking-widest text-xs font-black mb-2" />
                            <x-text-input id="zipcode" name="zipcode" type="text" class="w-full bg-black/50 border-white/10 focus:border-[#ff2a42] text-white" value="{{ old('zipcode', auth()->user()->zipcode ?? '') }}" required />
                        </div>
                        <div>
                            <x-input-label for="city" value="Woonplaats" class="text-gray-400 uppercase tracking-widest text-xs font-black mb-2" />
                            <x-text-input id="city" name="city" type="text" class="w-full bg-black/50 border-white/10 focus:border-[#ff2a42] text-white" value="{{ old('city', auth()->user()->city ?? '') }}" required />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-5">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl sticky top-28 shadow-2xl">
                    <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4">Samenvatting</h3>
                    
                    <div class="space-y-4 mb-8 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4 border-b border-white/5 pb-4 last:border-0 last:pb-0">
                                <div class="w-16 h-16 bg-black/50 rounded-xl overflow-hidden flex-shrink-0 border border-white/5">
                                    @if($item['image_path'])
                                        <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-white uppercase">{{ $item['name'] }}</h4>
                                    @if($item['variant_name'])
                                        <p class="text-xs text-[#ff2a42] font-bold uppercase">{{ $item['variant_name'] }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 font-bold mt-1">{{ $item['quantity'] }}x &euro; {{ number_format($item['unit_price'], 2, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-white">&euro; {{ number_format($item['unit_price'] * $item['quantity'], 2, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

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

                    <button type="submit" class="w-full bg-[#ff2a42] hover:bg-[#d91c30] text-white font-black py-5 px-8 rounded-xl transition-all uppercase tracking-[0.2em] flex items-center justify-center gap-4 shadow-[0_0_20px_rgba(255,42,66,0.3)] hover:shadow-[0_0_30px_rgba(255,42,66,0.5)] group hover:-translate-y-1">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Veilig Betalen
                    </button>
                    
                    <div class="mt-6 flex justify-center items-center gap-4 opacity-50">
                        <!-- Logos placeholders -->
                        <div class="text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            Stripe Secured
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-shop-layout>
