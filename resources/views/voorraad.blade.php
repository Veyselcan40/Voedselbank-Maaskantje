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

                @php
                    $showForm = old('_show_form') || $errors->any() || request('_show_form');
                    $producten = $producten ?? [
                        ['streepjescode' => '123456789', 'naam' => 'dal yarrak', 'categorie' => 'groente', 'aantal' => 10000],
                        ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120],
                        ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80],
                        ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45],
                    ];
                @endphp

                @if($showForm)
                    <div class="flex items-center justify-center min-h-[40vh]">
                        <div class="w-full max-w-2xl bg-white p-10 rounded-xl shadow-lg border border-gray-200">
                            <h3 class="text-2xl font-semibold mb-8 text-gray-800">Nieuw product toevoegen</h3>
                            <form method="POST" action="{{ route('voorraad.toevoegen') }}">
                                @csrf
                                <input type="hidden" name="_show_form" value="1" />
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="streepjescode" class="block font-medium text-gray-700 mb-1">Streepjescode</label>
                                        <input type="text" name="streepjescode" id="streepjescode" value="{{ old('streepjescode') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                                        @error('streepjescode')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="naam" class="block font-medium text-gray-700 mb-1">Productnaam</label>
                                        <input type="text" name="naam" id="naam" value="{{ old('naam') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                                        @error('naam')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="categorie" class="block font-medium text-gray-700 mb-1">Categorie</label>
                                        <input type="text" name="categorie" id="categorie" value="{{ old('categorie') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                                        @error('categorie')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="aantal" class="block font-medium text-gray-700 mb-1">Aantal</label>
                                        <input type="number" name="aantal" id="aantal" value="{{ old('aantal') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" min="1" required>
                                        @error('aantal')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex justify-between mt-4">
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
                        <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden shadow">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Streepjescode</th>
                                    <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Productnaam</th>
                                    <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Categorie</th>
                                    <th class="px-8 py-5 text-left font-semibold text-gray-700 border-b border-gray-200 text-base">Aantal</th>
                                    <th class="px-8 py-5 border-b border-gray-200 text-center text-base">Acties</th>
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
                                            <form method="POST" action="#" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-5 py-2 bg-red-500 text-white rounded-md font-semibold text-base hover:bg-red-600 transition shadow-sm"
                                                    onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
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
                @endif
            </div>
        </div>
    </div>
</x-app-layout>