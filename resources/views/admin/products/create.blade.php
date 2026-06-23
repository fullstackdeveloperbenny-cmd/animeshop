<x-admin-layout>
    <x-slot name="title">Nieuw Product</x-slot>
    <x-slot name="header">Product Aanmaken</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Nieuw Product Aanmaken</h2>
                        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900">
                            &larr; Terug naar overzicht
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Basis Info -->
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="name" value="Product Naam" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                </div>

                                <div>
                                    <x-input-label for="category_id" value="Categorie" />
                                    <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                        <option value="">Selecteer een categorie...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="price" value="Prijs (&euro;)" />
                                    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price')" required />
                                </div>

                                <div>
                                    <x-input-label for="base_stock" value="Standaard Voorraad (als er geen varianten zijn)" />
                                    <x-text-input id="base_stock" name="base_stock" type="number" class="mt-1 block w-full" :value="old('base_stock')" />
                                </div>

                                <div>
                                    <x-input-label for="badge" value="Badge (optioneel, bijv. 'Hot Drop')" />
                                    <x-text-input id="badge" name="badge" type="text" class="mt-1 block w-full" :value="old('badge')" />
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Product is actief (zichtbaar)</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_featured') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Uitgelicht product</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Beschrijving & Afbeeldingen -->
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="description" value="Beschrijving" />
                                    <textarea id="description" name="description" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>{{ old('description') }}</textarea>
                                </div>

                                <div class="border p-4 rounded-md bg-gray-50">
                                    <h3 class="font-bold mb-2">Afbeeldingen (optioneel)</h3>
                                    <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-2">Je kunt meerdere bestanden tegelijk selecteren. De eerste foto wordt automatisch de hoofdfoto.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Varianten sectie (simpel) -->
                        <div class="mb-6 border p-4 rounded-md bg-gray-50">
                            <h3 class="font-bold mb-4">Maten / Varianten (optioneel)</h3>
                            <div id="variants-container" class="space-y-4">
                                <!-- Eén rij standaard -->
                                <div class="flex gap-4 items-center">
                                    <div class="flex-1">
                                        <x-input-label value="Type (bijv. 'Maat')" />
                                        <select name="variants[0][type]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Selecteer...</option>
                                            <option value="Maat" selected>Maat</option>
                                            <option value="Kleur">Kleur</option>
                                            <option value="Taal">Taal</option>
                                            <option value="Editie">Editie</option>
                                            <option value="Anders">Anders...</option>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <x-input-label value="Waarde (bijv. 'XL')" />
                                        <x-text-input name="variants[0][value]" type="text" class="mt-1 block w-full" placeholder="Laat leeg indien geen variant" />
                                    </div>
                                    <div class="w-24">
                                        <x-input-label value="Voorraad" />
                                        <x-text-input name="variants[0][stock]" type="number" class="mt-1 block w-full" value="10" />
                                    </div>
                                    <div class="w-32">
                                        <x-input-label value="Prijs Extra (&euro;)" />
                                        <x-text-input name="variants[0][price_modifier]" type="number" step="0.01" class="mt-1 block w-full" value="0.00" />
                                    </div>
                                </div>
                                <div class="flex gap-4 items-center">
                                    <div class="flex-1">
                                        <select name="variants[1][type]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Selecteer...</option>
                                            <option value="Maat" selected>Maat</option>
                                            <option value="Kleur">Kleur</option>
                                            <option value="Taal">Taal</option>
                                            <option value="Editie">Editie</option>
                                            <option value="Anders">Anders...</option>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <x-text-input name="variants[1][value]" type="text" class="mt-1 block w-full" placeholder="Extra maat (bijv. 'L')" />
                                    </div>
                                    <div class="w-24">
                                        <x-text-input name="variants[1][stock]" type="number" class="mt-1 block w-full" value="10" />
                                    </div>
                                    <div class="w-32">
                                        <x-text-input name="variants[1][price_modifier]" type="number" step="0.01" class="mt-1 block w-full" value="0.00" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>Product Opslaan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
