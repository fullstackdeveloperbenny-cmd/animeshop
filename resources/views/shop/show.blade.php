<x-shop-layout>
    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-[#ff2a42]/10 blur-[150px] rounded-full"></div>
    </div>

    <!-- Breadcrumbs -->
    <div class="border-b border-white/5 bg-black/50 backdrop-blur-md sticky top-20 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">
                <a href="{{ route('shop.index') }}" class="hover:text-white transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Shop
                </a>
                <span class="mx-4 text-gray-700">/</span>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-white transition-colors">{{ $product->category->name }}</a>
                <span class="mx-4 text-gray-700">/</span>
                <span class="text-[#ff2a42] truncate">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            
            <!-- Linker Kolom: Afbeeldingen -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Hoofdfoto -->
                <div class="aspect-[4/5] bg-[#0a0a0a] border border-white/10 rounded-3xl overflow-hidden relative group shadow-2xl">
                    @if($primaryImage)
                        <img id="main-image" src="{{ asset('storage/' . $primaryImage->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-800 font-black tracking-widest uppercase bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
                            <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Geen Foto Beschikbaar
                        </div>
                    @endif
                    
                    @if($product->badge)
                        <div class="absolute top-6 left-6">
                            <span class="bg-[#ff2a42] text-white text-xs font-black px-4 py-2 rounded-lg uppercase tracking-[0.2em] shadow-[0_0_20px_rgba(255,42,66,0.5)]">
                                {{ $product->badge }}
                            </span>
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 border border-white/5 rounded-3xl pointer-events-none"></div>
                </div>

                <!-- Thumbnails -->
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <button onclick="document.getElementById('main-image').src='{{ asset('storage/' . $image->path) }}'" 
                                    class="aspect-square bg-[#0a0a0a] border border-white/10 hover:border-[#ff2a42] rounded-2xl overflow-hidden transition-all focus:outline-none focus:ring-2 focus:ring-[#ff2a42] hover:shadow-[0_0_15px_rgba(255,42,66,0.3)]">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Thumbnail" class="w-full h-full object-cover opacity-60 hover:opacity-100 transition-opacity">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Rechter Kolom: Product Info -->
            <div class="lg:col-span-5 flex flex-col">
                <div class="mb-10">
                    <p class="text-[#ff2a42] text-xs font-black uppercase tracking-[0.3em] mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#ff2a42] shadow-[0_0_10px_rgba(255,42,66,0.8)]"></span>
                        {{ $product->category->name }}
                    </p>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.1] mb-6 tracking-tight">{{ $product->name }}</h1>
                    <p class="text-4xl font-black text-white flex items-start gap-2">
                        <span class="text-2xl text-gray-500 mt-1">&euro;</span> 
                        <span id="display-price">{{ number_format($product->price, 2, ',', '.') }}</span>
                    </p>
                </div>

                <div class="prose prose-invert max-w-none text-gray-400 font-medium leading-relaxed mb-10 text-lg">
                    {!! nl2br(e($product->description)) !!}
                </div>

                <!-- Action Box (Glassmorphism) as a Form -->
                <form action="{{ route('cart.add', $product) }}" method="POST" class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl mb-10 shadow-2xl relative overflow-hidden">
                    @csrf
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
                    
                    @if($product->variants->isNotEmpty())
                        <div class="mb-8 relative z-10">
                            <label for="variant" class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3">
                                Selecteer {{ $product->variants->first()->type ?? 'variant' }}
                            </label>
                            <div class="relative">
                                <select id="variant" name="variant_id" class="w-full pl-6 pr-12 py-5 bg-black/50 bg-none border border-white/10 text-white rounded-xl focus:outline-none focus:border-[#ff2a42] focus:ring-1 focus:ring-[#ff2a42] font-bold text-lg appearance-none cursor-pointer transition-colors hover:bg-black/70">
                                    <option value="">Kies een optie...</option>
                                    @foreach($product->variants as $variant)
                                        <option value="{{ $variant->id }}" data-price="{{ $product->price + $variant->price_modifier }}" {{ $variant->stock == 0 ? 'disabled' : '' }}>
                                            {{ $variant->value }} 
                                            @if($variant->price_modifier > 0)
                                                (+ &euro; {{ number_format($variant->price_modifier, 2, ',', '.') }})
                                            @endif
                                            @if($variant->stock <= 5 && $variant->stock > 0)
                                                (Nog maar {{ $variant->stock }} over!)
                                            @elseif($variant->stock == 0)
                                                (Uitverkocht)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none text-[#ff2a42]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Aantal -->
                    <div class="mb-8 relative z-10">
                        <label for="quantity" class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Aantal</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="100" class="w-full pl-6 py-5 bg-black/50 border border-white/10 text-white rounded-xl focus:outline-none focus:border-[#ff2a42] focus:ring-1 focus:ring-[#ff2a42] font-bold text-lg transition-colors hover:bg-black/70">
                    </div>

                    <!-- Add to Cart -->
                    <button type="submit" class="relative z-10 w-full bg-[#ff2a42] hover:bg-[#d91c30] text-white font-black py-5 px-8 rounded-xl transition-all uppercase tracking-[0.2em] flex items-center justify-center gap-4 shadow-[0_0_20px_rgba(255,42,66,0.3)] hover:shadow-[0_0_30px_rgba(255,42,66,0.5)] group hover:-translate-y-1">
                        <svg class="w-6 h-6 transform group-hover:-rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Voeg Toe Aan Loot
                    </button>
                </form>
                
                <!-- Perks -->
                <div class="grid grid-cols-2 gap-4 mt-auto">
                    <div class="flex flex-col gap-3 text-gray-300 bg-white/5 border border-white/5 p-6 rounded-2xl hover:bg-white/10 transition-colors">
                        <svg class="w-8 h-8 text-[#ff2a42]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span class="text-xs font-black uppercase tracking-widest">Veilig<br>Verpakt</span>
                    </div>
                    <div class="flex flex-col gap-3 text-gray-300 bg-white/5 border border-white/5 p-6 rounded-2xl hover:bg-white/10 transition-colors">
                        <svg class="w-8 h-8 text-[#ff2a42]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="text-xs font-black uppercase tracking-widest">Snelle<br>Verzending</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script om prijs dynamisch aan te passen op basis van de variant -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantSelect = document.getElementById('variant');
            const displayPrice = document.getElementById('display-price');
            
            if (variantSelect && displayPrice) {
                const basePriceHtml = displayPrice.innerHTML;
                
                variantSelect.addEventListener('change', function() {
                    if (this.value) {
                        const selectedOption = this.options[this.selectedIndex];
                        const newPrice = parseFloat(selectedOption.getAttribute('data-price')).toFixed(2).replace('.', ',');
                        displayPrice.innerHTML = newPrice;
                    } else {
                        displayPrice.innerHTML = basePriceHtml;
                    }
                });
            }
        });
    </script>
</x-shop-layout>
