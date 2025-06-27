<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-4">Alle Voedselpakketten</h2>

        <a href="{{ route('voedselpakketten.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            Nieuw pakket toevoegen
        </a>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded shadow">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border-b text-left">Klant</th>
                        <th class="px-4 py-2 border-b text-left">Samenstelling</th>
                        <th class="px-4 py-2 border-b text-left">Uitgifte</th>
                        <th class="px-4 py-2 border-b text-left">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voedselpakketten as $pakket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $pakket->klant->naam }}</td>
                            <td class="px-4 py-2 border-b">{{ $pakket->datum_samenstelling }}</td>
                            <td class="px-4 py-2 border-b">{{ $pakket->datum_uitgifte ?? 'Nog niet uitgegeven' }}</td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('voedselpakketten.edit', $pakket->id) }}"
                                   class="text-blue-600 hover:underline mr-2">Wijzigen</a>

                                <form action="{{ route('voedselpakketten.destroy', $pakket->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Weet je het zeker?')"
                                            class="text-red-600 hover:underline">
                                        Verwijderen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
