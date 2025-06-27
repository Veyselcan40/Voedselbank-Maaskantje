<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakket Details
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Pakketinformatie</h3>
                <p><strong>Nummer:</strong> {{ $voedselpakket->nummer }}</p>
                <p><strong>Klant:</strong> {{ $voedselpakket->klant ? $voedselpakket->klant->naam : 'Geen klant toegewezen' }}</p>
                <p><strong>Datum Samenstelling:</strong> {{ $voedselpakket->datum_samenstelling }}</p>
                <p><strong>Datum Uitgifte:</strong> {{ $voedselpakket->datum_uitgifte ?? 'Nog niet uitgegeven' }}</p>
            </div>

            <div>
                <h3 class="font-semibold mb-2">Producten in dit pakket:</h3>
                @if($voedselpakket->producten && $voedselpakket->producten->count())
                    <ul class="list-disc pl-4">
                        @foreach($voedselpakket->producten as $product)
                            <li>{{ $product->naam }} ({{ $product->pivot->aantal }})</li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-gray-400">Geen producten</span>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('voedselpakketten.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    Terug naar overzicht
                </a>
            </div>
        </div>
    </div>
</x-app-layout>