<x-admin-layout>
    <x-slot name="header">
        Product Bewerken: {{ $product->name }}
    </x-slot>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow" role="alert">
            <p class="font-bold">Er zijn fouten in je formulier:</p>
            <ul class="list-disc ml-5 text-sm mt-2 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Linker Kolom: Basis Info & Varianten -->
            <div class="md:col-span-2 space-y-6">
                <!-- Basis Informatie Card -->
                <div class="bg-white p-8 rounded-lg shadow border border-gray-200">
                    <h3 class="text-lg font-black text-[#0A0A0A] uppercase tracking-wider mb-6 border-b pb-2">Basis Informatie</h3>
                    
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-black text-[#0A0A0A] mb-2 uppercase tracking-wider">
                            Productnaam <span class="text-[#E8192C]">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#E8192C] font-medium text-gray-800">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="category_id" class="block text-sm font-black text-[#0A0A0A] mb-2 uppercase tracking-wider">
                                Categorie <span class="text-[#E8192C]">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#E8192C] font-medium text-gray-800">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-black text-[#0A0A0A] mb-2 uppercase tracking-wider">
                                Basisprijs (&euro; incl. BTW) <span class="text-[#E8192C]">*</span>
                            </label>
                            <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $product->price) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#E8192C] font-medium text-gray-800">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="description" class="block text-sm font-black text-[#0A0A0A] mb-2 uppercase tracking-wider">
                            Product Omschrijving <span class="text-[#E8192C]">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#E8192C] font-medium text-gray-800">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <!-- Varianten Card -->
                <div class="bg-white p-8 rounded-lg shadow border border-gray-200">
                    <div class="flex justify-between items-center mb-6 border-b pb-2">
                        <h3 class="text-lg font-black text-[#0A0A0A] uppercase tracking-wider">Varianten (Maten/Kleuren)</h3>
                        <button type="button" onclick="addVariantRow()" class="text-xs bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 font-bold uppercase tracking-wider shadow">
                            + Voeg variant toe
                        </button>
                    </div>
                    
                    <div id="variants-container" class="space-y-4">
                        @php $vIndex = 0; @endphp
                        @foreach($product->variants as $variant)
                            <div class="variant-row grid grid-cols-4 gap-4 items-end bg-gray-50 p-4 rounded border border-gray-200">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Type</label>
                                    <select name="variants[{{ $vIndex }}][type]" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                                        <option value="Maat" {{ $variant->type == 'Maat' ? 'selected' : '' }}>Maat (Kledij)</option>
                                        <option value="Schaal" {{ $variant->type == 'Schaal' ? 'selected' : '' }}>Schaal (Figures)</option>
                                        <option value="Kleur" {{ $variant->type == 'Kleur' ? 'selected' : '' }}>Kleur</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Waarde</label>
                                    <input type="text" name="variants[{{ $vIndex }}][value]" value="{{ $variant->value }}" list="variant-values" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium" placeholder="Kies of typ...">
                                    <!-- Datalist staat 1x centraal voor alle rijen -->
                                    @if($vIndex === 0)
                                        <datalist id="variant-values">
                                            <option value="XS"><option value="S"><option value="M"><option value="L"><option value="XL"><option value="XXL"><option value="One Size">
                                            <option value="1/4"><option value="1/6"><option value="1/7"><option value="1/8">
                                        </datalist>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Voorraad</label>
                                    <input type="number" min="0" name="variants[{{ $vIndex }}][stock]" value="{{ $variant->stock }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Extra Prijs (&euro;)</label>
                                    <input type="number" step="0.01" name="variants[{{ $vIndex }}][price_modifier]" value="{{ $variant->price_modifier }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                                </div>
                            </div>
                            @php $vIndex++; @endphp
                        @endforeach
                        
                        <!-- Fallback row als het leeg is -->
                        @if($product->variants->isEmpty())
                            <div class="variant-row grid grid-cols-4 gap-4 items-end bg-gray-50 p-4 rounded border border-gray-200">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Type</label>
                                    <select name="variants[{{ $vIndex }}][type]" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                                        <option value="Maat">Maat (Kledij)</option>
                                        <option value="Schaal">Schaal (Figures)</option>
                                        <option value="Kleur">Kleur</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Waarde</label>
                                    <input type="text" name="variants[{{ $vIndex }}][value]" list="variant-values" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium" placeholder="Kies of typ...">
                                    <datalist id="variant-values">
                                        <option value="XS"><option value="S"><option value="M"><option value="L"><option value="XL"><option value="XXL"><option value="One Size">
                                        <option value="1/4"><option value="1/6"><option value="1/7"><option value="1/8">
                                    </datalist>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Voorraad</label>
                                    <input type="number" min="0" name="variants[{{ $vIndex }}][stock]" value="0" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Extra Prijs (&euro;)</label>
                                    <input type="number" step="0.01" name="variants[{{ $vIndex }}][price_modifier]" value="0" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                                </div>
                            </div>
                            @php $vIndex++; @endphp
                        @endif
                    </div>
                    <p class="text-xs text-[#E8192C] mt-4 font-bold">Maak het Type en de Waarde leeg om een bestaande variant te wissen bij het opslaan.</p>
                </div>
            </div>

            <!-- Rechter Kolom: Status & Media -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h3 class="text-sm font-black text-[#0A0A0A] uppercase tracking-wider mb-4 border-b pb-2">Zichtbaarheid</h3>
                    
                    <div class="mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-[#E8192C] border-gray-300 rounded focus:ring-[#E8192C] cursor-pointer">
                            <span class="ml-3 text-sm font-bold text-gray-800">Actief in webshop</span>
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="w-5 h-5 text-[#E8192C] border-gray-300 rounded focus:ring-[#E8192C] cursor-pointer">
                            <span class="ml-3 text-sm font-bold text-gray-800">Uitgelicht (Homepage)</span>
                        </label>
                    </div>

                    <div class="mb-2">
                        <label for="badge" class="block text-xs font-bold text-gray-700 mb-1">Label / Badge (Optioneel)</label>
                        <input type="text" name="badge" id="badge" value="{{ old('badge', $product->badge) }}" placeholder="bijv. NIEUW of SALE"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#E8192C] text-sm font-medium">
                    </div>
                </div>

                <!-- Media Card -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h3 class="text-sm font-black text-[#0A0A0A] uppercase tracking-wider mb-4 border-b pb-2">Afbeeldingen</h3>
                    
                    @if($product->images->isNotEmpty())
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            @foreach($product->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-24 object-cover rounded shadow-sm border border-gray-200">
                                    @if($image->is_primary)
                                        <span class="absolute top-1 left-1 bg-[#E8192C] text-white text-[9px] px-1.5 py-0.5 rounded font-black uppercase shadow">Primary</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border border-dashed border-gray-300 p-4 text-center rounded mb-6">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Nog geen foto's</p>
                        </div>
                    @endif

                    <label class="block text-xs font-bold text-gray-700 mb-2">Nieuwe Foto's Toevoegen</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-bold file:bg-[#0A0A0A] file:text-white hover:file:bg-gray-800 cursor-pointer">
                    <p class="text-[10px] text-gray-500 font-medium mt-2">Nieuwe foto's worden toegevoegd aan je bestaande foto's.</p>
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-6 pt-6 border-t border-gray-200">
            <button type="submit" class="bg-[#E8192C] hover:bg-red-700 text-white font-black py-4 px-10 rounded transition-colors uppercase tracking-wider shadow text-lg">
                Wijzigingen Opslaan
            </button>
            <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-[#0A0A0A] font-bold uppercase tracking-wider transition-colors">
                Annuleren
            </a>
        </div>
    </form>

    <script>
        let variantIndex = {{ $vIndex }};
        function addVariantRow() {
            const container = document.getElementById('variants-container');
            const html = `
                <div class="variant-row grid grid-cols-4 gap-4 items-end bg-gray-50 p-4 rounded border border-gray-200 mt-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Type</label>
                        <select name="variants[${variantIndex}][type]" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                            <option value="Maat">Maat (Kledij)</option>
                            <option value="Schaal">Schaal (Figures)</option>
                            <option value="Kleur">Kleur</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Waarde</label>
                        <input type="text" name="variants[${variantIndex}][value]" list="variant-values" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium" placeholder="Kies of typ...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Voorraad</label>
                        <input type="number" min="0" name="variants[${variantIndex}][stock]" value="0" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Extra Prijs (&euro;)</label>
                        <input type="number" step="0.01" name="variants[${variantIndex}][price_modifier]" value="0" class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-medium">
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            variantIndex++;
        }
    </script>
</x-admin-layout>
