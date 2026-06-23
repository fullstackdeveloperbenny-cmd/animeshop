<x-admin-layout>
    <x-slot name="title">Prullenbak Producten</x-slot>
    <x-slot name="header">Prullenbak Producten</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Verwijderde Producten</h2>
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors shadow">
                            &larr; Terug naar Overzicht
                        </a>
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
                                    <th class="p-3 border-b">Naam</th>
                                    <th class="p-3 border-b">Categorie</th>
                                    <th class="p-3 border-b">Verwijderd Op</th>
                                    <th class="p-3 border-b text-right">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trashedProducts as $product)
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="p-3">{{ $product->id }}</td>
                                        <td class="p-3">
                                            <span class="font-semibold text-gray-500 line-through">{{ $product->name }}</span>
                                        </td>
                                        <td class="p-3 text-gray-500">{{ $product->category?->name ?? 'Geen/Verwijderd' }}</td>
                                        <td class="p-3 text-gray-500">{{ $product->deleted_at->format('d-m-Y H:i') }}</td>
                                        <td class="p-3 text-right">
                                            <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt herstellen?');">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 font-bold flex items-center justify-end w-full gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                    Herstellen
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-3 text-center text-gray-500">De prullenbak is leeg.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $trashedProducts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
