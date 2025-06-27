<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-8 bg-white rounded-lg shadow mt-8">
        <h2 class="text-lg font-semibold mb-6 text-gray-900">Nieuwe leverancier toevoegen</h2>
        <form method="POST" action="{{ route('leverancier.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Bedrijfsnaam</label>
                <input type="text" name="Bedrijfsnaam" value="{{ old('Bedrijfsnaam') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Bedrijfsnaam') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Adres</label>
                <input type="text" name="Adres" value="{{ old('Adres') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Adres') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Contactpersoon</label>
                <input type="text" name="Contactpersoon" value="{{ old('Contactpersoon') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Contactpersoon') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="Email" value="{{ old('Email') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Telefoonnummer</label>
                <input type="text" name="Telefoon" value="{{ old('Telefoon') }}" required pattern="[0-9]*" inputmode="numeric" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Telefoon') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Eerstvolgende levering (optioneel)</label>
                <input type="datetime-local" name="EerstvolgendeLevering" value="{{ old('EerstvolgendeLevering') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('EerstvolgendeLevering') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('leverancier.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Annuleren</a>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Opslaan</button>
            </div>
        </form>
    </div>
</x-app-layout>
