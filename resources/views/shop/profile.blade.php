<x-shop-layout>
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-[#ff2a42]/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="mb-12">
            <h1 class="text-4xl sm:text-5xl font-black text-white uppercase tracking-widest mb-4">Mijn Profiel</h1>
            <p class="text-gray-400">Welkom terug, {{ $user->name }}. Beheer hier je gegevens en bekijk je ordergeschiedenis.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Linker Kolom: Profielgegevens -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
                    <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6 relative z-10">Jouw Gegevens</h3>
                    
                    <div class="space-y-4 relative z-10">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Naam</p>
                            <p class="text-white font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">E-mailadres</p>
                            <p class="text-white font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Lid Sinds</p>
                            <p class="text-white font-medium">{{ $user->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="pt-6 mt-6 border-t border-white/10 flex flex-col gap-3">
                            <!-- Linkt naar profile edit -->
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-white uppercase tracking-widest transition-colors">
                                Wachtwoord / Gegevens Wijzigen
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            
                            <!-- Uitloggen -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center text-sm font-bold text-[#ff2a42] hover:text-[#d91c30] uppercase tracking-widest transition-colors mt-4">
                                    Uitloggen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rechter Kolom: Ordergeschiedenis -->
            <div class="lg:col-span-8">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
                    <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4">Mijn Bestellingen</h3>
                    
                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <a href="{{ route('customer.order', $order) }}" class="block bg-black/40 border border-white/5 hover:border-[#ff2a42]/50 p-6 rounded-2xl transition-all group">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                        <div>
                                            <p class="text-sm text-gray-400 font-bold uppercase tracking-widest mb-1">{{ $order->created_at->format('d-m-Y') }}</p>
                                            <p class="text-lg font-black text-white group-hover:text-[#ff2a42] transition-colors">{{ $order->order_number }}</p>
                                        </div>
                                        
                                        <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
                                            <p class="text-lg font-black text-white">&euro; {{ number_format($order->total_price, 2, ',', '.') }}</p>
                                            
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                                    'paid' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                                    'shipped' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                                    'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'In afwachting',
                                                    'paid' => 'Betaald',
                                                    'shipped' => 'Verzonden',
                                                    'cancelled' => 'Geannuleerd',
                                                ];
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors[$order->status] ?? 'bg-white/10 text-white' }}">
                                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                            </span>
                                            
                                            <svg class="w-5 h-5 text-gray-600 group-hover:text-[#ff2a42] transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <p class="text-gray-400 font-medium mb-6">Je hebt nog geen bestellingen geplaatst.</p>
                            <a href="{{ route('shop.index') }}" class="inline-block bg-[#ff2a42] hover:bg-[#d91c30] text-white font-black py-3 px-8 rounded-xl transition-all uppercase tracking-widest text-sm">
                                Naar de Shop
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-shop-layout>
