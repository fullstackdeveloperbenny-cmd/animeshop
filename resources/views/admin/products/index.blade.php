<x-admin-layout>
    <x-slot name="header">
        Producten Beheer
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-[#0A0A0A]">Alle Producten</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-[#E8192C] hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors shadow">
            + Nieuw Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow" role="alert">
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-6 py-4 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                        Afbeelding
                    </th>
                    <th class="px-6 py-4 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th class="px-6 py-4 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                        Prijs
                    </th>
                    <th class="px-6 py-4 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 border-b-2 border-gray-200 bg-gray-50 text-right text-xs font-black text-gray-500 uppercase tracking-wider">
                        Acties
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="{{ $product->name }}" class="h-14 w-14 object-cover rounded shadow border border-gray-200">
                            @else
                                <div class="h-14 w-14 bg-gray-100 flex items-center justify-center rounded border border-gray-200 text-gray-400 text-[10px] font-bold text-center">
                                    GEEN FOTO
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            <p class="text-[#0A0A0A] font-bold text-base whitespace-no-wrap">
                                {{ $product->name }}
                                @if($product->badge)
                                    <span class="ml-2 bg-[#E8192C] text-white text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-wider">{{ $product->badge }}</span>
                                @endif
                            </p>
                            <p class="text-gray-400 font-semibold text-xs mt-1">
                                Categorie: {{ $product->category->name }}
                            </p>
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            <p class="text-gray-900 font-bold whitespace-no-wrap">
                                &euro; {{ number_format($product->price, 2, ',', '.') }}
                            </p>
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold {{ $product->is_active ? 'text-green-800' : 'text-red-800' }} leading-tight">
                                <span aria-hidden class="absolute inset-0 {{ $product->is_active ? 'bg-green-100' : 'bg-red-100' }} rounded-full"></span>
                                <span class="relative text-xs uppercase tracking-wider">{{ $product->is_active ? 'Actief' : 'Inactief' }}</span>
                            </span>
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm text-right">
                            <div class="flex justify-end gap-4 items-center">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 font-bold text-xs uppercase tracking-wider">
                                    Bewerken
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen? (Het blijft als soft-delete verborgen in de database)');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#E8192C] hover:text-red-900 font-bold text-xs uppercase tracking-wider">
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 bg-white text-sm text-center text-gray-500 font-semibold">
                            Er zijn nog geen producten gevonden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-admin-layout>
