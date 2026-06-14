<x-shop-layout>
    <div class="fixed inset-0 z-[-1] bg-black pointer-events-none">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-green-500/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10 text-center">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-12 rounded-3xl shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
            
            <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-[0_0_30px_rgba(34,197,94,0.5)]">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h1 class="text-4xl sm:text-5xl font-black text-white uppercase tracking-widest mb-4">Bedankt voor je bestelling!</h1>
            <p class="text-gray-400 text-lg mb-8">Je betaling is succesvol ontvangen en we gaan direct voor je aan de slag.</p>

            <div class="bg-black/50 border border-white/10 p-6 rounded-2xl inline-block mb-12">
                <p class="text-gray-500 text-sm font-bold uppercase tracking-widest mb-2">Jouw Ordernummer</p>
                <p class="text-2xl font-black text-[#ff2a42] tracking-widest">{{ $order->order_number }}</p>
            </div>

            <div>
                <a href="{{ route('shop.index') }}" class="inline-flex bg-[#ff2a42] hover:bg-[#d91c30] text-white font-black py-4 px-8 rounded-xl transition-all uppercase tracking-[0.2em] items-center justify-center gap-4 shadow-[0_0_20px_rgba(255,42,66,0.3)] hover:shadow-[0_0_30px_rgba(255,42,66,0.5)] group hover:-translate-y-1">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Terug Naar Home
                </a>
            </div>
        </div>
    </div>
</x-shop-layout>
