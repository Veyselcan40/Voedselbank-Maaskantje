<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>

<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Voedselpakketten</h1>
    <a href="{{ route('voedselpakket.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-6">Nieuw Voedselpakket</a>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($voedselpakketten->count())
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Klant</th>
                    <th class="py-2 px-4 border-b">Datum Samenstelling</th>
                    <th class="py-2 px-4 border-b">Datum Uitgifte</th>
                    <th class="py-2 px-4 border-b">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voedselpakketten as $pakket)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $pakket->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $pakket->klant->naam ?? 'Onbekend' }}</td>
                    <td class="py-2 px-4 border-b">{{ $pakket->datum_samenstelling->format('d-m-Y') }}</td>
                    <td class="py-2 px-4 border-b">{{ $pakket->datum_uitgifte ? $pakket->datum_uitgifte->format('d-m-Y') : '-' }}</td>
                    <td class="py-2 px-4 border-b space-x-2">
                        <a href="{{ route('voedselpakket.show', $pakket->id) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Bekijk</a>
                        <a href="{{ route('voedselpakket.edit', $pakket->id) }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">Bewerk</a>
                        <form action="{{ route('voedselpakket.destroy', $pakket->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Weet je het zeker?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Verwijder</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="mt-4 text-gray-600">Geen voedselpakketten gevonden.</p>
    @endif
</div>
</x-app-layout>
