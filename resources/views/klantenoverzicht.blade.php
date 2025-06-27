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
                    <h3 class="text-lg font-semibold mb-4">Overzicht van alle klanten</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">Naam</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">Adres</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">Telefoonnummer</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-700">E-mailadres</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($klanten as $klant)
                                    <tr>
                                        <td class="px-4 py-2">{{ $klant['naam'] }}</td>
                                        <td class="px-4 py-2">{{ $klant['adres'] }}</td>
                                        <td class="px-4 py-2">{{ $klant['telefoon'] }}</td>
                                        <td class="px-4 py-2">{{ $klant['email'] }}</td>
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
  
