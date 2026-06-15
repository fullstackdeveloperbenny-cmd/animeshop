<x-admin-layout>
    <x-slot name="header">
        Overzicht
    </x-slot>

    <!-- Statistieken Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Totale Omzet -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center text-green-600 mr-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Totale Omzet</p>
                <h3 class="text-2xl font-black text-[#0A0A0A]">&euro; {{ number_format($totalRevenue, 2, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Aantal Bestellingen -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Bestellingen</p>
                <h3 class="text-2xl font-black text-[#0A0A0A]">{{ $totalOrders }}</h3>
            </div>
        </div>

        <!-- Aantal Producten -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 mr-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Producten</p>
                <h3 class="text-2xl font-black text-[#0A0A0A]">{{ $totalProducts }}</h3>
            </div>
        </div>

        <!-- Aantal Klanten -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 mr-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Klanten</p>
                <h3 class="text-2xl font-black text-[#0A0A0A]">{{ $totalCustomers }}</h3>
            </div>
        </div>
    </div>

    <!-- Recente Bestellingen -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-black text-[#0A0A0A] uppercase tracking-wider">Recente Bestellingen</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-[#E8192C] hover:text-red-700 uppercase tracking-wider">Bekijk alles &rarr;</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Datum</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Ordernummer</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Klant</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Totaal</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actie</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-500 font-medium">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="p-4 text-sm font-black text-[#0A0A0A]">{{ $order->order_number }}</td>
                            <td class="p-4 text-sm text-[#0A0A0A] font-medium">
                                {{ $order->first_name }} {{ $order->last_name }}
                                <span class="block text-xs text-gray-400">{{ $order->email }}</span>
                            </td>
                            <td class="p-4 text-sm font-black text-[#0A0A0A]">&euro; {{ number_format($order->total_price, 2, ',', '.') }}</td>
                            <td class="p-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-block px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-[#E8192C] hover:text-white rounded-lg text-xs font-bold uppercase tracking-wider transition-colors">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                Er zijn nog geen bestellingen geplaatst.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
