<x-app-layout>
    <!-- Witte balk onder de navbar met schaduw -->
    <div class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <h1 class="text-base font-semibold text-black tracking-tight">Leveranciers Overzicht</h1>
        </div>
    </div>
    <!-- Extra ruimte tussen de balk en de container -->
    <div class="h-6"></div>
    <div class="max-w-7xl mx-auto px-6 py-8 bg-white rounded-lg shadow">
        @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex items-center justify-between mb-6">
            <p class="text-base font-semibold text-black tracking-tight">Overzicht van alle leveranciers</p>
            <a href="{{ route('leverancier.create') }}"
               class="text-green-600 hover:underline hover:text-green-800 text-sm font-semibold transition">
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
                <thead class="bg-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Bedrijfsnaam</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Adres</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Contactpersoon</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">E-mail</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Telefoonnummer</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Eerstvolgende levering</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Acties</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($leveranciers as $leverancier)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-sm text-black">{{ $leverancier->Bedrijfsnaam }}</td>
                        <td class="px-4 py-2 text-sm text-black">{{ $leverancier->Adres }}</td>
                        <td class="px-4 py-2 text-sm text-black">{{ $leverancier->Contactpersoon }}</td>
                        <td class="px-4 py-2 text-sm text-black">{{ $leverancier->Email }}</td>
                        <td class="px-4 py-2 text-sm text-black">{{ $leverancier->Telefoon }}</td>
                        <td class="px-4 py-2 text-sm text-black">
                            @if($leverancier->EerstvolgendeLevering)
                                {{ \Carbon\Carbon::parse($leverancier->EerstvolgendeLevering)->format('d-m-Y H:i') }}
                            @else
                                <span class="text-gray-400">Geen gepland</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex flex-row gap-4">
                                <a href="{{ route('leverancier.edit', $leverancier->id) }}"
                                   class="text-blue-600 hover:underline hover:text-blue-800 text-sm font-semibold transition">
                                    Bewerken
                                </a>
                                <form method="POST" action="{{ route('leverancier.destroy', $leverancier->id) }}" onsubmit="return confirm('Weet je zeker dat je deze leverancier wilt verwijderen?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:underline hover:text-red-800 text-sm font-semibold transition bg-transparent border-0 p-0 m-0 align-baseline">
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            <nav class="flex space-x-1" role="navigation" aria-label="Pagination">
                @if ($leveranciers->onFirstPage())
                    <span class="px-3 py-2 bg-gray-100 text-gray-400 border border-gray-200 rounded cursor-default">&laquo;</span>
                @else
                    <a href="{{ $leveranciers->previousPageUrl() }}" class="px-3 py-2 bg-white text-gray-700 border border-gray-200 rounded hover:bg-gray-50">&laquo;</a>
                @endif

                @foreach ($leveranciers->getUrlRange(1, $leveranciers->lastPage()) as $page => $url)
                    @if ($page == $leveranciers->currentPage())
                        <span class="px-3 py-2 bg-indigo-600 text-white border border-indigo-600 rounded font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 bg-white text-gray-700 border border-gray-200 rounded hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($leveranciers->hasMorePages())
                    <a href="{{ $leveranciers->nextPageUrl() }}" class="px-3 py-2 bg-white text-gray-700 border border-gray-200 rounded hover:bg-gray-50">&raquo;</a>
                @else
                    <span class="px-3 py-2 bg-gray-100 text-gray-400 border border-gray-200 rounded cursor-default">&raquo;</span>
                @endif
            </nav>
        </div>
    </div>
</x-app-layout>

