<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Voorraadbeheer') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                    <h3 class="text-2xl font-bold text-gray-800">Productvoorraadbeheer</h3>
                    <a href="{{ route('voorraad', ['_show_form' => 1]) }}"
                       class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 transition text-base">
                        Product toevoegen
                    </a>
                </div>
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->has('aantal'))
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow">
                        Vul het veld 'Aantal' in met een waarde groter dan 0.
                    </div>
                @endif

                @php
                    $showForm = old('_show_form') || $errors->any() || request('_show_form');
                    $categorieen = ['Voedsel', 'Verzorging', 'Drinken', 'Overig'];
                    $producten = $producten ?? [
                        ['streepjescode' => '1234567890123', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120],
                        ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80],
                        ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45],
                    ];
                @endphp

                @if($showForm)
                    <div class="flex items-center justify-center min-h-[40vh]">
                        <div class="w-full max-w-6xl bg-white p-10 rounded-xl shadow-lg border border-gray-200">
                            <h3 class="text-2xl font-semibold mb-8 text-gray-800">Nieuw product toevoegen</h3>
                            <form method="POST" action="{{ route('voorraad.toevoegen') }}">
                                @csrf
                                <input type="hidden" name="_show_form" value="1" />
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                                    <div>
                                        <label for="streepjescode" class="block font-medium text-gray-700 mb-1">Streepjescode</label>
                                        <input type="text"
                                            name="streepjescode"
                                            id="streepjescode"
                                            value="{{ old('streepjescode') }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                            required
                                            minlength="13"
                                            maxlength="13"
                                            pattern="\d{13}"
                                            inputmode="numeric"
                                            placeholder="13 cijfers"
                                        >
                                    </div>
                                    <div>
                                        <label for="naam" class="block font-medium text-gray-700 mb-1">Productnaam</label>
                                        <input type="text"
                                            name="naam"
                                            id="naam"
                                            value="{{ old('naam') }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                            required
                                            pattern="^[A-Za-zÀ-ÿ\s]+$"
                                            title="Alleen letters toegestaan"
                                            autocomplete="off"
                                        >
                                    </div>
                                    <div>
                                        <label for="categorie" class="block font-medium text-gray-700 mb-1">Categorie</label>
                                        <select name="categorie" id="categorie"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                            required>
                                            <option value="">-- Kies categorie --</option>
                                            @foreach($categorieen as $cat)
                                                <option value="{{ $cat }}" @selected(old('categorie') == $cat)>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="aantal" class="block font-medium text-gray-700 mb-1">Aantal</label>
                                        <input type="number"
                                            name="aantal"
                                            id="aantal"
                                            value="{{ old('aantal') }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="flex justify-between mt-4 w-full">
                                    <a href="{{ route('voorraad') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">Annuleren</a>
                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                        Opslaan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] border border-gray-200 rounded-xl overflow-hidden shadow">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Streepjescode</th>
                                <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Productnaam</th>
                                <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Categorie</th>
                                <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Aantal</th>
                                <th class="px-8 py-5 border-b border-gray-200 text-center text-base" style="width:220px;">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($producten as $product)
                                <tr class="bg-white hover:bg-blue-50 transition border-b border-gray-100">
                                    <td class="px-8 py-5">{{ $product['streepjescode'] }}</td>
                                    <td class="px-8 py-5">{{ $product['naam'] }}</td>
                                    <td class="px-8 py-5">{{ $product['categorie'] }}</td>
                                    <td class="px-8 py-5">{{ $product['aantal'] }}</td>
                                    <td class="px-8 py-5 text-center">
                                        <div class="flex flex-row gap-3 justify-center items-center">
                                            <a href="{{ route('voorraad.bewerk', $product['streepjescode']) }}"
                                               class="px-5 py-2 bg-blue-500 text-white rounded-md font-semibold text-base hover:bg-blue-600 transition shadow-sm">
                                                Bewerken
                                            </a>
                                            <button
                                                onclick="showDeleteModal('{{ $product['streepjescode'] }}')"
                                                class="px-5 py-2 bg-red-500 text-white rounded-md font-semibold text-base hover:bg-red-600 transition shadow-sm"
                                                type="button"
                                            >
                                                Verwijderen
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Verwijder bevestigingsmodal -->
                    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
                            <h2 class="text-xl font-bold mb-4 text-gray-800">Weet je zeker dat je dit product wilt verwijderen?</h2>
                            <form id="deleteForm" method="POST" action="">
                                @csrf
                                {{-- Gebruik geen DELETE method spoofing, alleen POST --}}
                                <div class="flex justify-end gap-4 mt-6">
                                    <button type="button" onclick="hideDeleteModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 font-semibold">Annuleren</button>
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">Verwijderen</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                    function showDeleteModal(streepjescode) {
                        const modal = document.getElementById('deleteModal');
                        const form = document.getElementById('deleteForm');
                        form.action = "{{ url('voorraad/verwijder') }}/" + streepjescode;
                        modal.classList.remove('hidden');
                    }
                    function hideDeleteModal() {
                        document.getElementById('deleteModal').classList.add('hidden');
                    }
                    </script>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>