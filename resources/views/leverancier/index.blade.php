<x-app-layout>
    <!-- Witte balk onder de navbar met schaduw -->
    <div class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <h1 class="text-base font-semibold text-gray-900 tracking-tight">Leveranciers Overzicht</h1>
        </div>
    </div>
    <!-- Extra ruimte tussen de balk en de container -->
    <div class="h-6"></div>
    <div class="max-w-7xl mx-auto px-6 py-8 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between mb-6">
            <p class="text-base font-semibold text-gray-900 tracking-tight">Overzicht van alle leveranciers</p>
            <a href="{{ route('leverancier.create') }}"
                class="inline-block px-4 py-2 bg-green-500 text-white text-sm font-medium rounded hover:bg-green-600 transition">
                Leverancier toevoegen
            </a>
        </div>
        @if($errors->any())
            <div class="mb-4 text-red-600">
                {{ $errors->first() }}
            </div>
        @endif
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Bedrijfsnaam</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Adres</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contactpersoon</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">E-mail</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Telefoonnummer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Eerstvolgende levering</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acties</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($leveranciers as $leverancier)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $leverancier->Bedrijfsnaam }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $leverancier->Adres }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $leverancier->Contactpersoon }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $leverancier->Email }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $leverancier->Telefoon }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">
                            @if($leverancier->EerstvolgendeLevering)
                                {{ \Carbon\Carbon::parse($leverancier->EerstvolgendeLevering)->format('d-m-Y H:i') }}
                            @else
                                <span class="text-gray-400">Geen gepland</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex flex-row gap-2">
                                <a href="{{ route('leverancier.edit', $leverancier->id) }}" class="px-5 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Bewerken</a>
                                <a href="#" class="px-5 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">Verwijderen</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
