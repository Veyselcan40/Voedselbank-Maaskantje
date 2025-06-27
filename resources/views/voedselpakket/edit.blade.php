<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>
    <h2>Voedselpakket Wijzigen</h2>
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('voedselpakketten.update', $voedselpakket->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Klant:</label>
        <select name="klant_id" required>
            <option value="">-- Selecteer een klant --</option>
            @foreach ($klanten as $klant)
                <option value="{{ $klant->id }}" {{ $voedselpakket->klant_id == $klant->id ? 'selected' : '' }}>
                    {{ $klant->naam }}
                </option>
            @endforeach
        </select><br>

        <label>Datum Samenstelling:</label>
        <input type="date" name="datum_samenstelling" value="{{ $voedselpakket->datum_samenstelling }}"><br>

        <label>Datum Uitgifte:</label>
        <input type="date" name="datum_uitgifte" value="{{ $voedselpakket->datum_uitgifte }}"><br>

        {{-- Placeholder voor producten-selectie indien van toepassing --}}
        {{-- <label>Producten:</label>
        <select name="producten[]" multiple>
            ... 
        </select><br> --}}

        <button type="submit">Opslaan</button>
    </form>
</x-app-layout>

