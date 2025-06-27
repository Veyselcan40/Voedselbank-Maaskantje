<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Voedselpakketten Overzicht
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-4">Alle Voedselpakketten</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('voedselpakketten.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            Nieuw pakket toevoegen
        </a>

        <div class="overflow-x-auto">
            @if($voedselpakketten->count() === 0)
                <div class="p-6 text-gray-600">
                    Er zijn momenteel geen voedselpakketten beschikbaar.
                </div>
            @else
            <table class="min-w-full bg-white border border-gray-200 rounded shadow">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border-b text-left">Nummer</th>
                        <th class="px-4 py-2 border-b text-left">Klant</th>
                        <th class="px-4 py-2 border-b text-left">Samenstelling</th>
                        <th class="px-4 py-2 border-b text-left">Uitgifte</th>
                        <th class="px-4 py-2 border-b text-left">Producten</th>
                        <th class="px-4 py-2 border-b text-left">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voedselpakketten as $pakket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $pakket->nummer }}</td>
                            <td class="px-4 py-2 border-b">
                                {{ $pakket->klant ? $pakket->klant->naam : 'Onbekende klant' }}
                            </td>
                            <td class="px-4 py-2 border-b">{{ $pakket->datum_samenstelling }}</td>
                            <td class="px-4 py-2 border-b">{{ $pakket->datum_uitgifte ?? 'Nog niet uitgegeven' }}</td>
                            <td class="px-4 py-2 border-b">
                                @if($pakket->producten && $pakket->producten->count())
                                    <ul class="list-disc pl-4">
                                        @foreach($pakket->producten as $product)
                                            <li>{{ $product->naam }} ({{ $product->pivot->aantal }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400">Geen producten</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('voedselpakketten.edit', $pakket->id) }}"
                                   class="text-blue-600 hover:underline mr-2">Wijzigen</a>
                                <button
                                    type="button"
                                    onclick="openVerwijderModal({{ $pakket->id }})"
                                    class="text-red-600 hover:underline"
                                >
                                    Verwijderen
                                </button>
                                <form id="verwijder-form-{{ $pakket->id }}" action="{{ route('voedselpakketten.destroy', $pakket->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <!-- Modal voor bevestigen verwijderen -->
        <div id="verwijder-modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
            <div class="bg-white p-6 rounded shadow max-w-sm w-full">
                <h3 class="text-lg font-bold mb-4 text-center text-red-700">Weet je zeker dat je dit voedselpakket wilt verwijderen?</h3>
                <div class="flex justify-center gap-4">
                    <button id="modal-verwijder-btn" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition font-semibold">
                        Verwijderen
                    </button>
                    <button onclick="closeVerwijderModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition font-semibold">
                        Annuleren
                    </button>
                </div>
            </div>
        </div>
        <script>
            let currentVerwijderId = null;
            function openVerwijderModal(id) {
                currentVerwijderId = id;
                document.getElementById('verwijder-modal').classList.remove('hidden');
            }
            function closeVerwijderModal() {
                document.getElementById('verwijder-modal').classList.add('hidden');
                currentVerwijderId = null;
            }
            document.getElementById('modal-verwijder-btn').onclick = function() {
                if (currentVerwijderId) {
                    var form = document.getElementById('verwijder-form-' + currentVerwijderId);
                    if (form) {
                        form.submit();
                    }
                }
            };
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeVerwijderModal();
                }
            });
        </script>
    </div>
</x-app-layout>
