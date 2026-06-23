<x-admin-layout>
    <x-slot name="title">Producten</x-slot>
    <x-slot name="header">Producten Beheer</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Producten Beheer</h2>
                        <div class="flex gap-4">
                            <a href="{{ route('admin.products.trash') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors shadow flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Prullenbak
                            </a>
                            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 font-bold flex items-center">
                                + Nieuw Product
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 border-b">ID</th>
                                    <th class="p-3 border-b">Foto</th>
                                    <th class="p-3 border-b">Naam</th>
                                    <th class="p-3 border-b">Categorie</th>
                                    <th class="p-3 border-b">Prijs</th>
                                    <th class="p-3 border-b">Status</th>
                                    <th class="p-3 border-b text-right">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="p-3">{{ $product->id }}</td>
                                        <td class="p-3">
                                            @if($product->primaryImage)
                                                <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">Geen</div>
                                            @endif
                                        </td>
                                        <td class="p-3 font-semibold">{{ $product->name }}</td>
                                        <td class="p-3">{{ $product->category?->name ?? 'Geen/Verwijderd' }}</td>
                                        <td class="p-3">&euro; {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="p-3 flex flex-col gap-1 items-start">
                                            @if($product->is_active)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Actief</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Inactief</span>
                                            @endif
                                            
                                            @if($product->variants->where('stock', '<=', 5)->count() > 0)
                                                <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full font-bold">
                                                    ⚠️ Lage Voorraad
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-right">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Bewerken</a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-3 text-center text-gray-500">Geen producten gevonden.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
