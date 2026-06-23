<x-admin-layout>
    <x-slot name="title">Prullenbak Categorieën</x-slot>
    <x-slot name="header">Prullenbak Categorieën</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-[#0A0A0A]">Verwijderde Categorieën</h2>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors shadow">
            &larr; Terug naar Overzicht
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
                        Naam & Slug
                    </th>
                    <th class="px-6 py-4 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                        Verwijderd Op
                    </th>
                    <th class="px-6 py-4 border-b-2 border-gray-200 bg-gray-50 text-right text-xs font-black text-gray-500 uppercase tracking-wider">
                        Acties
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($trashedCategories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            <p class="text-gray-500 font-bold text-base whitespace-no-wrap line-through">
                                {{ $category->name }}
                            </p>
                            <p class="text-gray-400 text-xs mt-1">/{{ $category->slug }}</p>
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm text-gray-500">
                            {{ $category->deleted_at->format('d-m-Y H:i') }}
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm text-right">
                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze categorie wilt herstellen?');">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 font-bold text-xs uppercase tracking-wider flex items-center gap-1 justify-end w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                    Herstellen
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 bg-white text-sm text-center text-gray-500 font-semibold">
                            De prullenbak is leeg.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginatie knoppen -->
    <div class="mt-6">
        {{ $trashedCategories->links() }}
    </div>
</x-admin-layout>
