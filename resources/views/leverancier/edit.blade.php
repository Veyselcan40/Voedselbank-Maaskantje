<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-8 bg-white rounded-lg shadow mt-8">
        <h2 class="text-lg font-semibold mb-6 text-gray-900">Leverancier wijzigen</h2>
        @if ($errors->has('Bedrijfsnaam'))
            <div class="mb-6 flex justify-center">
                <div class="px-6 py-3 rounded bg-red-100 text-red-800 border border-red-200 text-center font-semibold">
                    {{ $errors->first('Bedrijfsnaam') }}
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('leverancier.update', $leverancier->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Bedrijfsnaam</label>
                <input type="text" name="Bedrijfsnaam" value="{{ old('Bedrijfsnaam', $leverancier->Bedrijfsnaam) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Bedrijfsnaam') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Adres</label>
                <input type="text" name="Adres" value="{{ old('Adres', $leverancier->Adres) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Adres') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Contactpersoon</label>
                <input type="text" name="Contactpersoon" value="{{ old('Contactpersoon', $leverancier->Contactpersoon) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Contactpersoon') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="Email" value="{{ old('Email', $leverancier->Email) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Telefoonnummer</label>
                <input type="text" name="Telefoon" value="{{ old('Telefoon', $leverancier->Telefoon) }}" required pattern="[0-9]*" inputmode="numeric" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('Telefoon') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Type leverancier</label>
                <select name="Leverancierstype" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="">Selecteer type</option>
                    <option value="groothandel" {{ old('Leverancierstype', $leverancier->Leverancierstype) == 'groothandel' ? 'selected' : '' }}>Groothandel</option>
                    <option value="supermarkt" {{ old('Leverancierstype', $leverancier->Leverancierstype) == 'supermarkt' ? 'selected' : '' }}>Supermarkt</option>
                    <option value="boeren" {{ old('Leverancierstype', $leverancier->Leverancierstype) == 'boeren' ? 'selected' : '' }}>Boeren</option>
                </select>
                @error('Leverancierstype') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Actief</label>
                <select name="Actief" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="1" {{ old('Actief', $leverancier->Actief) == '1' ? 'selected' : '' }}>Ja</option>
                    <option value="0" {{ old('Actief', $leverancier->Actief) == '0' ? 'selected' : '' }}>Nee</option>
                </select>
                @error('Actief') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Eerstvolgende levering (optioneel)</label>
                <input type="datetime-local" name="EerstvolgendeLevering" value="{{ old('EerstvolgendeLevering', $leverancier->EerstvolgendeLevering ? \Carbon\Carbon::parse($leverancier->EerstvolgendeLevering)->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('EerstvolgendeLevering') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('leverancier.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Annuleren</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Opslaan</button>
            </div>
        </form>
    </div>
</x-app-layout>
