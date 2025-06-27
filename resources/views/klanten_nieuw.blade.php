<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuwe klant registreren
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('klanten.nieuw.post') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="naam" class="block font-medium text-sm text-gray-700">Naam</label>
                            <input type="text" name="naam" id="naam" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('naam') }}">
                            @error('naam')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="adres" class="block font-medium text-sm text-gray-700">Adres</label>
                            <input type="text" name="adres" id="adres" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('adres') }}">
                            @error('adres')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="telefoon" class="block font-medium text-sm text-gray-700">Telefoonnummer</label>
                            <input type="text" name="telefoon" id="telefoon" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('telefoon') }}">
                            @error('telefoon')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">E-mailadres</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded" required value="{{ old('email') }}">
                            @error('email')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Opslaan</button>
                            <a href="{{ route('klantenoverzicht') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Annuleren</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
