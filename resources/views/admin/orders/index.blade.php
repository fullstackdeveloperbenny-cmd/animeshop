<x-admin-layout>
    <x-slot name="title">Bestellingen</x-slot>
    <x-slot name="header">Bestellingen Overzicht</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Bestellingen Overzicht</h2>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b-2 border-gray-200">
                                    <th class="p-3 font-bold uppercase text-gray-600 text-xs tracking-wider">Datum</th>
                                    <th class="p-3 font-bold uppercase text-gray-600 text-xs tracking-wider">Ordernummer</th>
                                    <th class="p-3 font-bold uppercase text-gray-600 text-xs tracking-wider">Klant</th>
                                    <th class="p-3 font-bold uppercase text-gray-600 text-xs tracking-wider">Totaal</th>
                                    <th class="p-3 font-bold uppercase text-gray-600 text-xs tracking-wider">Status</th>
                                    <th class="p-3 font-bold uppercase text-gray-600 text-xs tracking-wider">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="p-3 text-sm text-gray-600">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                        <td class="p-3 font-bold text-gray-800">{{ $order->order_number }}</td>
                                        <td class="p-3">
                                            <div class="font-bold text-gray-800">{{ $order->first_name }} {{ $order->last_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->email }}</div>
                                        </td>
                                        <td class="p-3 font-bold text-[#ff2a42]">&euro; {{ number_format($order->total_price, 2, ',', '.') }}</td>
                                        <td class="p-3">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'paid' => 'bg-green-100 text-green-800 border-green-200',
                                                    'shipped' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'In afwachting',
                                                    'paid' => 'Betaald (Nieuw!)',
                                                    'shipped' => 'Verzonden',
                                                    'cancelled' => 'Geannuleerd',
                                                ];
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1 bg-gray-800 text-white text-xs font-bold rounded-md hover:bg-gray-700 transition-colors">
                                                Details Bekijken
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-gray-500">
                                            Er zijn nog geen bestellingen geplaatst.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
