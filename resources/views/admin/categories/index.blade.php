<x-admin-layout>
    <x-slot name="title">Categorieën</x-slot>
    <x-slot name="header">Categorieën Beheer</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-[#0A0A0A]">Alle Categorieën</h2>
        <div class="flex gap-4">
            <a href="{{ route('admin.categories.trash') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors shadow flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Prullenbak
            </a>
            <a href="{{ route('admin.categories.create') }}" class="bg-[#E8192C] hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors shadow">
                + Nieuwe Categorie
            </a>
        </div>
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
                        Hoofdcategorie
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
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            <p class="text-[#0A0A0A] font-bold text-base whitespace-no-wrap">
                                {{ $category->name }}
                            </p>
                            <p class="text-gray-400 text-xs mt-1">/{{ $category->slug }}</p>
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            @if($category->parent)
                                <span class="bg-gray-100 text-gray-700 font-bold px-3 py-1 rounded-full text-xs">
                                    {{ $category->parent->name }}
                                </span>
                            @else
                                <span class="text-gray-400 font-semibold italic text-xs">Hoofdcategorie</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold {{ $category->is_active ? 'text-green-800' : 'text-red-800' }} leading-tight">
                                <span aria-hidden class="absolute inset-0 {{ $category->is_active ? 'bg-green-100' : 'bg-red-100' }} rounded-full"></span>
                                <span class="relative text-xs uppercase tracking-wider">{{ $category->is_active ? 'Actief' : 'Inactief' }}</span>
                            </span>
                        </td>
                        <td class="px-6 py-5 border-b border-gray-100 bg-white text-sm text-right">
                            <div class="flex justify-end gap-4 items-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 font-bold text-xs uppercase tracking-wider">
                                    Bewerken
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze categorie wilt verwijderen? (Alle producten blijven behouden via Soft Deletes)');">
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
                        <td colspan="4" class="px-6 py-8 bg-white text-sm text-center text-gray-500 font-semibold">
                            Er zijn nog geen categorieën aangemaakt.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginatie knoppen -->
    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</x-admin-layout>
