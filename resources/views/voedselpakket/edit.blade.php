<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>
<h2>Voedselpakket Bewerken</h2>
<form action="{{ route('voedselpakketten.update', $voedselpakket->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Klant:</label>
    <select name="klant_id">
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

    <button type="submit">Bijwerken</button>
</form>
</x-app-layout>

