<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Klant bewerken
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('klanten.bewerken.post', $klant->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="naam" class="block font-medium text-sm text-gray-700">Naam</label>
                            <input type="text" name="naam" id="naam" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('naam', $klant->naam) }}">
                            @error('naam')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="adres" class="block font-medium text-sm text-gray-700">Adres</label>
                            <input type="text" name="adres" id="adres" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('adres', $klant->adres) }}">
                            @error('adres')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="telefoon" class="block font-medium text-sm text-gray-700">Telefoonnummer</label>
                            <input type="text" name="telefoon" id="telefoon" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('telefoon', $klant->telefoon) }}">
                            @error('telefoon')
                                <div class="text-red-600 text-sm">Het telefoonnummer moet minimaal 10 en maximaal 12 cijfers bevatten</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">E-mailadres</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('email', $klant->email) }}">
                            @error('email')
                                <div class="text-red-600 text-sm">Voer een geldig E-mailadres in</div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Opslaan</button>
                            <a href="{{ route('klantenoverzicht') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Annuleren</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


