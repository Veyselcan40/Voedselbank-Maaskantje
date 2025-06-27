<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Klantenoverzicht
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Overzicht van alle klanten</h3>
                        <a href="{{ route('klanten.nieuw') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Klant toevoegen</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">Naam</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">Adres</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">Telefoonnummer</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">E-mailadres</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($klanten as $klant)
                                    <tr>
                                        <td class="px-4 py-2">{{ $klant['naam'] }}</td>
                                        <td class="px-4 py-2">{{ $klant['adres'] }}</td>
                                        <td class="px-4 py-2">{{ $klant['telefoon'] }}</td>
                                        <td class="px-4 py-2">{{ $klant['email'] }}</td>
                                        <td class="px-4 py-2">
                                            <a href="#" class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">Bewerken</a>
                                            <form action="#" method="POST" class="inline-block" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Verwijderen</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

