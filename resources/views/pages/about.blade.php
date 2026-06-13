<x-shop-layout>
    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-[600px] h-[600px] bg-[#ff2a42]/10 blur-[120px] rounded-full"></div>
    </div>

    <!-- Header -->
    <div class="border-b border-white/5 bg-black/50 backdrop-blur-md pt-20 pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tight mb-6">
                Over <span class="text-[#ff2a42] neon-text">Ons</span>
            </h1>
            <p class="text-xl text-gray-400 font-medium max-w-2xl mx-auto">
                Ontdek het verhaal achter AnimaShop, ontstaan uit pure passie voor Anime en de Japanse popcultuur.
            </p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-10 rounded-3xl shadow-2xl space-y-8">
            <div class="prose prose-invert prose-lg max-w-none text-gray-300">
                <h2 class="text-2xl font-black uppercase tracking-wider text-white mb-4 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-[#ff2a42] shadow-[0_0_10px_rgba(255,42,66,0.8)]"></span>
                    Onze Missie
                </h2>
                <p>
                    Bij AnimaShop geloven we dat Anime meer is dan alleen entertainment; het is een levensstijl. Onze missie is simpel: we willen de meest authentieke, kwalitatieve en exclusieve Anime merchandise toegankelijk maken voor fans in de hele Benelux. Geen goedkope namaak, maar 100% officiële loot direct uit Japan en van gelicentieerde partners.
                </p>

                <div class="my-10 border-l-4 border-[#ff2a42] pl-6 bg-black/30 p-6 rounded-r-xl">
                    <p class="text-xl font-bold italic text-white mb-0">
                        "Van Otaku, voor Otaku. Wij importeren alleen wat we zélf in onze collectie zouden willen hebben."
                    </p>
                </div>

                <h2 class="text-2xl font-black uppercase tracking-wider text-white mb-4 flex items-center gap-3 mt-12">
                    <span class="w-2 h-2 rounded-full bg-[#ff2a42] shadow-[0_0_10px_rgba(255,42,66,0.8)]"></span>
                    Waarom AnimaShop?
                </h2>
                <ul class="space-y-4">
                    <li class="flex items-start gap-4">
                        <svg class="w-6 h-6 text-[#ff2a42] flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>100% Authentiek:</strong> Al onze figures, manga en kleding zijn gegarandeerd officieel gelicentieerd.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <svg class="w-6 h-6 text-[#ff2a42] flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Verpakt met Zorg:</strong> We weten hoe waardevol collectibles zijn. Jouw bestelling wordt perfect beschermd verzonden.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <svg class="w-6 h-6 text-[#ff2a42] flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Community First:</strong> We luisteren naar onze klanten. Zoek je een specifieke zeldzame figure? Laat het ons weten!</span>
                    </li>
                </ul>
            </div>
            
            <div class="pt-8 mt-8 border-t border-white/10 text-center">
                <p class="text-gray-400 mb-6">Klaar om je collectie uit te breiden?</p>
                <a href="{{ route('shop.index') }}" class="inline-flex bg-[#ff2a42] hover:bg-[#d91c30] text-white font-black py-4 px-10 rounded-xl transition-all uppercase tracking-[0.2em] shadow-[0_0_20px_rgba(255,42,66,0.3)] hover:shadow-[0_0_30px_rgba(255,42,66,0.5)] hover:-translate-y-1">
                    Naar de Shop
                </a>
            </div>
        </div>
    </div>
</x-shop-layout>
