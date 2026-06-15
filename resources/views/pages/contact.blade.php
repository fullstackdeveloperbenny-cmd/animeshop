<x-shop-layout>
    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute bottom-0 right-1/4 w-[700px] h-[500px] bg-[#ff2a42]/10 blur-[150px] rounded-full"></div>
    </div>

    <!-- Header -->
    <div class="border-b border-white/5 bg-black/50 backdrop-blur-md pt-20 pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tight mb-6">
                Neem <span class="text-[#ff2a42] neon-text">Contact</span> Op
            </h1>
            <p class="text-xl text-gray-400 font-medium max-w-2xl mx-auto">
                Vragen over een product, je bestelling, of wil je gewoon praten over de nieuwste anime aflevering? Laat het ons weten!
            </p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
            
            <!-- Contact Informatie -->
            <div class="flex flex-col space-y-8">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl hover:border-[#ff2a42]/30 transition-colors">
                    <h2 class="text-xl font-black uppercase tracking-widest text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#ff2a42]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Onze Base
                    </h2>
                    <p class="text-gray-300 leading-relaxed font-medium">
                        AnimaShop HQ<br>
                        Otakustraat 42<br>
                        1000 Brussel<br>
                        België
                    </p>
                </div>

                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl hover:border-[#ff2a42]/30 transition-colors">
                    <h2 class="text-xl font-black uppercase tracking-widest text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#ff2a42]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Digitaal Bereikbaar
                    </h2>
                    <p class="text-gray-300 leading-relaxed font-medium">
                        Email: <a href="mailto:support@animashop.test" class="text-[#ff2a42] hover:text-white transition-colors">support@animashop.test</a><br>
                        Discord: <a href="#" class="text-[#ff2a42] hover:text-white transition-colors">AnimaShop Community</a>
                    </p>
                </div>
            </div>

            <!-- Contact Formulier -->
            <div class="bg-black border border-white/10 p-10 rounded-3xl shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-[#ff2a42]/5 to-transparent pointer-events-none"></div>
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/50 text-green-400 font-bold text-sm text-center relative z-10">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('pages.contact.send') }}" method="POST" class="relative z-10 space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Jouw Naam</label>
                        <input type="text" id="name" name="name" placeholder="Senpai" required class="w-full px-5 py-4 bg-[#0a0a0a] border border-white/10 text-white rounded-xl focus:outline-none focus:border-[#ff2a42] focus:ring-1 focus:ring-[#ff2a42] font-medium transition-colors">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Jouw Email</label>
                        <input type="email" id="email" name="email" placeholder="senpai@example.com" required class="w-full px-5 py-4 bg-[#0a0a0a] border border-white/10 text-white rounded-xl focus:outline-none focus:border-[#ff2a42] focus:ring-1 focus:ring-[#ff2a42] font-medium transition-colors">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Je Bericht</label>
                        <textarea id="message" name="message" rows="5" placeholder="Typ hier je bericht..." required class="w-full px-5 py-4 bg-[#0a0a0a] border border-white/10 text-white rounded-xl focus:outline-none focus:border-[#ff2a42] focus:ring-1 focus:ring-[#ff2a42] font-medium transition-colors resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#ff2a42] hover:bg-[#d91c30] text-white font-black py-5 rounded-xl transition-all uppercase tracking-[0.2em] shadow-[0_0_20px_rgba(255,42,66,0.3)] hover:shadow-[0_0_30px_rgba(255,42,66,0.5)] hover:-translate-y-1">
                        Verstuur Bericht
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-shop-layout>
