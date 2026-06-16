<x-admin-layout>
    <x-slot name="title">Product Bewerken</x-slot>
    <x-slot name="header">Bewerk Product: {{ $product->name }}</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Product Bewerken: {{ $product->name }}</h2>
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

                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Basis Info -->
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="name" value="Product Naam" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required />
                                </div>

                                <div>
                                    <x-input-label for="category_id" value="Categorie" />
                                    <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="price" value="Prijs (&euro;)" />
                                    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price', $product->price)" required />
                                </div>

                                <div>
                                    <x-input-label for="badge" value="Badge (optioneel)" />
                                    <x-text-input id="badge" name="badge" type="text" class="mt-1 block w-full" :value="old('badge', $product->badge)" />
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Product is actief</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Uitgelicht product</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Beschrijving & Afbeeldingen -->
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="description" value="Beschrijving" />
                                    <textarea id="description" name="description" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div class="border p-4 rounded-md bg-gray-50">
                                    <h3 class="font-bold mb-2">Huidige Afbeeldingen</h3>
                                    <div class="flex gap-2 mb-4">
                                        @forelse($product->images as $img)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $img->path) }}" class="w-20 h-20 object-cover rounded border">
                                                @if($img->is_primary)
                                                    <span class="absolute top-0 left-0 bg-blue-500 text-white text-[10px] px-1 rounded-br">Hoofd</span>
                                                @endif
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500">Geen foto's</p>
                                        @endforelse
                                    </div>

                                    <h3 class="font-bold mb-2">Nieuwe Afbeeldingen (Overschrijft huidige)</h3>
                                    <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                            </div>
                        </div>

                        <!-- Varianten sectie (simpel) -->
                        <div class="mb-6 border p-4 rounded-md bg-gray-50">
                            <h3 class="font-bold mb-4">Varianten (Huidige worden overschreven)</h3>
                            <div id="variants-container" class="space-y-4">
                                @forelse($product->variants as $index => $variant)
                                    <div class="flex gap-4 items-center">
                                        <div class="flex-1">
                                            <x-input-label value="Type" />
                                            <select name="variants[{{$index}}][type]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Selecteer...</option>
                                                <option value="Maat" {{ $variant->type == 'Maat' ? 'selected' : '' }}>Maat</option>
                                                <option value="Kleur" {{ $variant->type == 'Kleur' ? 'selected' : '' }}>Kleur</option>
                                                <option value="Taal" {{ $variant->type == 'Taal' ? 'selected' : '' }}>Taal</option>
                                                <option value="Editie" {{ $variant->type == 'Editie' ? 'selected' : '' }}>Editie</option>
                                                <option value="Anders" {{ !in_array($variant->type, ['Maat', 'Kleur', 'Taal', 'Editie']) && $variant->type ? 'selected' : '' }}>Anders ({{ $variant->type }})</option>
                                            </select>
                                        </div>
                                        <div class="flex-1">
                                            <x-input-label value="Waarde" />
                                            <x-text-input name="variants[{{$index}}][value]" type="text" class="mt-1 block w-full" :value="$variant->value" />
                                        </div>
                                        <div class="w-24">
                                            <x-input-label value="Voorraad" />
                                            <x-text-input name="variants[{{$index}}][stock]" type="number" class="mt-1 block w-full" :value="$variant->stock" />
                                        </div>
                                        <div class="w-32">
                                            <x-input-label value="Prijs Extra" />
                                            <x-text-input name="variants[{{$index}}][price_modifier]" type="number" step="0.01" class="mt-1 block w-full" :value="$variant->price_modifier" />
                                        </div>
                                    </div>
                                @empty
                                    <!-- Lege default rijen -->
                                    <div class="flex gap-4 items-center">
                                        <div class="flex-1">
                                            <x-input-label value="Type" />
                                            <select name="variants[0][type]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Selecteer...</option>
                                                <option value="Maat" selected>Maat</option>
                                                <option value="Kleur">Kleur</option>
                                                <option value="Taal">Taal</option>
                                                <option value="Editie">Editie</option>
                                            </select>
                                        </div>
                                        <div class="flex-1"><x-input-label value="Waarde" /><x-text-input name="variants[0][value]" type="text" class="mt-1 block w-full" placeholder="Laat leeg indien geen variant" /></div>
                                        <div class="w-24"><x-input-label value="Voorraad" /><x-text-input name="variants[0][stock]" type="number" class="mt-1 block w-full" value="10" /></div>
                                        <div class="w-32"><x-input-label value="Prijs Extra" /><x-text-input name="variants[0][price_modifier]" type="number" step="0.01" class="mt-1 block w-full" value="0.00" /></div>
                                    </div>
                                @endforelse
                                
                                <!-- Een extra lege rij voor toevoegen -->
                                @php $nextIndex = $product->variants->count(); @endphp
                                <div class="flex gap-4 items-center mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex-1">
                                        <x-input-label value="Nieuw Type" />
                                        <select name="variants[{{$nextIndex}}][type]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Selecteer...</option>
                                            <option value="Maat" selected>Maat</option>
                                            <option value="Kleur">Kleur</option>
                                            <option value="Taal">Taal</option>
                                            <option value="Editie">Editie</option>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <x-input-label value="Nieuwe Waarde" />
                                        <x-text-input name="variants[{{$nextIndex}}][value]" type="text" class="mt-1 block w-full" placeholder="Nieuwe variant toevoegen" />
                                    </div>
                                    <div class="w-24">
                                        <x-input-label value="Voorraad" />
                                        <x-text-input name="variants[{{$nextIndex}}][stock]" type="number" class="mt-1 block w-full" value="10" />
                                    </div>
                                    <div class="w-32">
                                        <x-input-label value="Prijs Extra" />
                                        <x-text-input name="variants[{{$nextIndex}}][price_modifier]" type="number" step="0.01" class="mt-1 block w-full" value="0.00" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>Wijzigingen Opslaan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
