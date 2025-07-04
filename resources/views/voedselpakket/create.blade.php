<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>
    <div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Nieuw Voedselpakket</h2>
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-400">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('voedselpakketten.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
            <label for="klant_id" class="block text-gray-700 mb-1">Klant</label>
            <select name="klant_id" id="klant_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- Selecteer een klant (optioneel) --</option>
                @foreach($klanten as $klant)
                    <option value="{{ $klant->id }}">{{ $klant->naam }}</option>
                @endforeach
            </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Datum Samenstelling:</label>
                <input type="date" name="datum_samenstelling" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Datum Uitgifte:</label>
                <input type="date" name="datum_uitgifte" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Producten uit voorraad:</label>
                <div class="space-y-2">
                    @if($producten->isEmpty())
                        <div class="text-red-600 font-semibold mb-2">
                            Er zijn geen producten in voorraad. Maak eerst producten aan.
                        </div>
                    @else
                        @foreach($producten as $product)
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="producten[{{ $loop->index }}][id]" value="{{ $product->id }}" id="product-{{ $product->id }}">
                                <label for="product-{{ $product->id }}" class="flex-1">
                                    {{ $product->streepjescode }} - {{ $product->naam }} ({{ $product->categorie }}) - {{ $product->aantal }} op voorraad
                                </label>
                                <input type="number" name="producten[{{ $loop->index }}][aantal]" min="1" max="{{ $product->aantal }}" placeholder="Aantal" class="w-24 border rounded px-2 py-1" required>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Opslaan</button>
        </form>
    </div>
</x-app-layout>
