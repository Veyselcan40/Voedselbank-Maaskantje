<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>
    <div class="flex justify-center items-center min-h-[60vh]">
        <div class="w-full max-w-lg bg-white p-8 rounded shadow">
            <h2 class="text-2xl font-bold mb-6 text-center">Voedselpakket Wijzigen</h2>
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-400">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('voedselpakketten.update', $voedselpakket->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 mb-1">Klant:</label>
                    <select name="klant_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        <option value="">-- Selecteer een klant (optioneel) --</option>
                        @foreach ($klanten as $klant)
                            <option value="{{ $klant->id }}" {{ $voedselpakket->klant_id == $klant->id ? 'selected' : '' }}>
                                {{ $klant->naam }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Datum Samenstelling:</label>
                    <input type="date" name="datum_samenstelling" value="{{ $voedselpakket->datum_samenstelling }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Datum Uitgifte:</label>
                    <input type="date" name="datum_uitgifte" value="{{ $voedselpakket->datum_uitgifte }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                {{-- Placeholder voor producten-selectie indien van toepassing --}}
                {{-- <div>
                    <label class="block text-gray-700 mb-1">Producten:</label>
                    <select name="producten[]" multiple class="w-full border border-gray-300 rounded px-3 py-2">
                        ...
                    </select>
                </div> --}}

                <div class="flex justify-center gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                        Opslaan
                    </button>
                    <a href="{{ route('voedselpakketten.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition font-semibold">
                        Annuleren
                    </a>
                </div>
            </form>
            {{-- Verwijderen knop en bevestigingsdiv zijn verwijderd --}}
        </div>
    </div>
</x-app-layout>

