<x-shop-layout>
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute top-0 left-0 w-[800px] h-[800px] bg-[#ff2a42]/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="mb-8">
            <a href="{{ route('customer.profile') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-[#ff2a42] uppercase tracking-widest transition-colors mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Terug naar profiel
            </a>
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-white uppercase tracking-widest mb-1">Order {{ $order->order_number }}</h1>
                    <p class="text-gray-400 font-medium">Geplaatst op {{ $order->created_at->format('d M Y \o\m H:i') }}</p>
                </div>
                
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                        'paid' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                        'shipped' => 'bg-green-500/20 text-green-400 border-green-500/30',
                        'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
                    ];
                    $statusLabels = [
                        'pending' => 'In afwachting van betaling',
                        'paid' => 'Betaald & in behandeling',
                        'shipped' => 'Verzonden - Onderweg!',
                        'cancelled' => 'Geannuleerd',
                    ];
                @endphp
                <span class="px-4 py-2 rounded-xl text-sm font-black uppercase tracking-widest border {{ $statusColors[$order->status] ?? 'bg-white/10 text-white' }} self-start sm:self-auto">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl relative overflow-hidden mb-8">
            <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4">Verzendgegevens</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-white font-medium">{{ $order->first_name }} {{ $order->last_name }}</p>
                    <p class="text-gray-400">{{ $order->email }}</p>
                </div>
                <div>
                    <p class="text-white font-medium">{{ $order->address }}</p>
                    <p class="text-white font-medium">{{ $order->zipcode }} {{ $order->city }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl relative overflow-hidden">
            <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4">Bestelde Producten</h3>
            
            <div class="space-y-4 mb-8">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <!-- Weergeven van plaatje is hier lastig tenzij we de relation $item->product->images inladen, maar we doen even alleen tekst -->
                        <div class="flex-1">
                            <h4 class="text-base font-bold text-white uppercase">
                                @if($item->product_id)
                                    <a href="{{ route('shop.show', $item->product->slug ?? '') }}" class="hover:text-[#ff2a42] transition-colors">{{ $item->product_name }}</a>
                                @else
                                    {{ $item->product_name }}
                                @endif
                            </h4>
                            @if($item->variant_name)
                                <p class="text-xs text-[#ff2a42] font-bold uppercase tracking-widest mt-1">{{ $item->variant_name }}</p>
                            @endif
                            <p class="text-sm text-gray-500 font-bold mt-1">{{ $item->quantity }}x &euro; {{ number_format($item->unit_price, 2, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black text-white">&euro; {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="space-y-4 border-t border-white/10 pt-6">
                <div class="flex justify-between text-gray-400 font-bold">
                    <span>Subtotaal</span>
                    <span>&euro; {{ number_format($order->total_price, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-400 font-bold">
                    <span>Verzendkosten</span>
                    <span class="text-green-400">Gratis</span>
                </div>
                <div class="pt-4 border-t border-white/10 flex justify-between items-end mt-4">
                    <span class="text-white font-black uppercase tracking-widest">Totaal betaald</span>
                    <span class="text-3xl font-black text-[#ff2a42]">
                        <span class="text-xl text-gray-500">&euro;</span> {{ number_format($order->total_price, 2, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</x-shop-layout>
