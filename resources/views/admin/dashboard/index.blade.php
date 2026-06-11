<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Content Panel (Witte achtergrond, vergelijkbaar met foto 2) -->
    <div class="bg-white border border-gray-200">
        <!-- Panel Header -->
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-sm font-black uppercase tracking-wider text-[#0A0A0A]">Systeem Overzicht</h2>
        </div>
        
        <!-- Panel Body -->
        <div class="p-6">
            <p class="text-gray-600 mb-8 font-medium">
                Welkom terug, {{ Auth::user()->name }}. Vanaf hier heb je toegang tot alle systeeminstellingen en de catalogus.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-gray-200 p-6 flex flex-col items-center justify-center">
                    <div class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-2">Totaal Bestellingen</div>
                    <div class="text-4xl font-black text-[#E8192C]">0</div>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center justify-center">
                    <div class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-2">Actieve Producten</div>
                    <div class="text-4xl font-black text-[#E8192C]">0</div>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center justify-center">
                    <div class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-2">Nieuwe Klanten</div>
                    <div class="text-4xl font-black text-[#E8192C]">0</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
