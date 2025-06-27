<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>
    <div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Nieuw Voedselpakket</h2>
        <form action="{{ route('voedselpakketten.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
            <label for="klant_id" class="block text-gray-700 mb-1">Klant</label>
            <select name="klant_id" id="klant_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                <option value="">-- Selecteer een klant --</option>
                @foreach($klanten as $klant)
                    <option value="{{ $klant->id }}">{{ $klant->naam }}</option>
                @endforeach
            </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Datum Samenstelling:</label>
                <input type="date" name="datum_samenstelling" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Datum Uitgifte:</label>
                <input type="date" name="datum_uitgifte" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Opslaan</button>
        </form>
    </div>
</x-app-layout>
