<x-admin-layout>
    <x-slot name="title">Nieuwe Categorie</x-slot>
    <x-slot name="header">Categorie Aanmaken</x-slot>

    <div class="max-w-3xl bg-white p-8 rounded-lg shadow border border-gray-200">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-black text-[#0A0A0A] mb-2 uppercase tracking-wider">
                    Categorienaam <span class="text-[#E8192C]">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    placeholder="bijv. T-Shirts"
                    class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#E8192C] focus:border-transparent font-medium">
                @error('name')
                    <p class="text-[#E8192C] font-semibold text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="slug" class="block text-sm font-black text-[#0A0A0A] mb-2 uppercase tracking-wider">
                    Custom Slug (Optioneel)
                </label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                    placeholder="bijv. naruto-merchandise"
                    class="w-full px-4 py-3 border border-gray-300 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#E8192C] focus:border-transparent font-medium text-gray-600">
                <p class="text-xs text-gray-500 font-medium mt-2">Laat dit leeg om automatisch een web-adres te genereren op basis van de naam.</p>
                @error('slug')
                    <p class="text-[#E8192C] font-semibold text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="parent_id" class="block text-sm font-black text-[#0A0A0A] mb-2 uppercase tracking-wider">
                    Valt onder (Hoofdcategorie)
                </label>
                <select name="parent_id" id="parent_id" 
                    class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#E8192C] focus:border-transparent font-medium">
                    <option value="">-- Dit is een zelfstandige hoofdcategorie --</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="text-[#E8192C] font-semibold text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-10 bg-gray-50 p-4 rounded border border-gray-100">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-6 h-6 text-[#E8192C] border-gray-300 rounded focus:ring-[#E8192C] cursor-pointer">
                    <div class="ml-3">
                        <span class="block text-sm font-black text-[#0A0A0A] uppercase tracking-wider">Categorie is Actief</span>
                        <span class="block text-xs text-gray-500 font-medium mt-1">Klanten kunnen deze categorie zien in de webshop.</span>
                    </div>
                </label>
                @error('is_active')
                    <p class="text-[#E8192C] font-semibold text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-6 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-[#E8192C] hover:bg-red-700 text-white font-black py-3 px-8 rounded transition-colors uppercase tracking-wider text-sm shadow">
                    Aanmaken
                </button>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-[#0A0A0A] font-bold text-sm uppercase tracking-wider transition-colors">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
