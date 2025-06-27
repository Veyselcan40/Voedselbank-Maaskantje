<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Klantenoverzicht
        </h2>
    </x-slot>

    <div x-data="{ showModal: false, deleteAction: null }" class="py-12">
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
                        @if($klanten->isEmpty())
                            <div class="p-6 text-center text-gray-600">
                                Er zijn nog geen klanten beschikbaar.
                            </div>
                        @else
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
                                            <td class="px-4 py-2">{{ $klant->naam }}</td>
                                            <td class="px-4 py-2">{{ $klant->adres }}</td>
                                            <td class="px-4 py-2">{{ $klant->telefoon }}</td>
                                            <td class="px-4 py-2">{{ $klant->email }}</td>
                                            <td class="px-4 py-2">
                                                <a href="{{ route('klanten.bewerken', $klant->id) }}" class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">Bewerken</a>
                                                <form 
                                                    action="{{ route('klanten.verwijderen', $klant->id) }}" 
                                                    method="POST" 
                                                    class="inline-block delete-form"
                                                    @submit.prevent="showModal = true; deleteAction = $event.target;"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Verwijderen</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <!-- Modal -->
                    <div x-show="showModal" style="background: rgba(0,0,0,0.5)" class="fixed inset-0 flex items-center justify-center z-50">
                        <div class="bg-white rounded shadow-lg p-8 max-w-sm w-full text-center">
                            <h2 class="text-lg font-semibold mb-4">Weet je zeker dat je de klant wilt verwijderen?</h2>
                            <div class="flex justify-center gap-4">
                                <button @click="showModal = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Annuleren</button>
                                <button @click="deleteAction.submit(); showModal = false" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Verwijderen</button>
                            </div>
                        </div>
                    </div>
                    <!-- Einde Modal -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


