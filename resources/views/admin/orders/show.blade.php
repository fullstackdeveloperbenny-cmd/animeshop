<x-admin-layout>
    <x-slot name="title">Bestelling #{{ $order->order_number }}</x-slot>
    <x-slot name="header">Bestelling #{{ $order->order_number }}</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-bold text-gray-600 hover:text-[#ff2a42] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Terug naar overzicht
                </a>
                
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'paid' => 'bg-green-100 text-green-800 border-green-200',
                        'shipped' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                    ];
                    $statusLabels = [
                        'pending' => 'In afwachting',
                        'paid' => 'Betaald',
                        'shipped' => 'Verzonden',
                        'cancelled' => 'Geannuleerd',
                    ];
                @endphp
                <div class="text-right">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Huidige Status</p>
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold border {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Gegevens -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-widest border-b pb-3 mb-4">Order Gegevens</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Ordernummer</p>
                            <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Datum Geplaatst</p>
                            <p class="font-bold text-gray-900">{{ $order->created_at->format('d-m-Y H:i:s') }}</p>
                        </div>
                        @if($order->stripe_session_id)
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Stripe Sessie ID</p>
                            <p class="font-mono text-xs text-gray-900 break-all">{{ $order->stripe_session_id }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Klant Gegevens -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-widest border-b pb-3 mb-4">Klant (Verzendadres)</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="font-bold text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="text-sm text-gray-600"><a href="mailto:{{ $order->email }}" class="text-[#ff2a42] hover:underline">{{ $order->email }}</a></p>
                        </div>
                        <div class="pt-2 border-t border-gray-100">
                            <p class="text-gray-900 font-medium">{{ $order->address }}</p>
                            <p class="text-gray-900 font-medium">{{ $order->zipcode }} {{ $order->city }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Update -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-2 border-gray-100">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-widest border-b pb-3 mb-4">Status Wijzigen</h3>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <x-input-label for="status" value="Nieuwe Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-[#ff2a42] focus:ring-[#ff2a42] rounded-md shadow-sm">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>In afwachting</option>
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Betaald</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Verzonden</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <button type="submit" class="w-full bg-[#ff2a42] hover:bg-[#d91c30] text-white font-bold py-2 px-4 rounded-md transition-colors uppercase tracking-widest text-sm">
                            Status Opslaan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bestelde Producten -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-black text-gray-800 uppercase tracking-widest border-b pb-4 mb-6">Bestelde Producten</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-3 font-bold uppercase text-gray-500 text-xs tracking-wider">Product</th>
                                <th class="p-3 font-bold uppercase text-gray-500 text-xs tracking-wider">Variant</th>
                                <th class="p-3 font-bold uppercase text-gray-500 text-xs tracking-wider">Prijs P/S</th>
                                <th class="p-3 font-bold uppercase text-gray-500 text-xs tracking-wider">Aantal</th>
                                <th class="p-3 font-bold uppercase text-gray-500 text-xs tracking-wider text-right">Subtotaal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-bold text-gray-800">
                                        @if($item->product_id)
                                            <a href="{{ route('shop.show', $item->product->slug ?? '') }}" target="_blank" class="hover:text-[#ff2a42]">{{ $item->product_name }}</a>
                                        @else
                                            {{ $item->product_name }} <span class="text-xs text-gray-400 font-normal">(Product verwijderd)</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-sm text-gray-600">
                                        @if($item->variant_name)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold">{{ $item->variant_name }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="p-3 text-sm text-gray-600">&euro; {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                    <td class="p-3 font-bold text-gray-900">{{ $item->quantity }}x</td>
                                    <td class="p-3 font-black text-[#ff2a42] text-right">&euro; {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t-2 border-gray-200">
                            <tr>
                                <td colspan="4" class="p-4 text-right font-bold text-gray-600 uppercase tracking-widest text-sm">Eindtotaal</td>
                                <td class="p-4 text-right font-black text-2xl text-[#ff2a42]">&euro; {{ number_format($order->total_price, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
