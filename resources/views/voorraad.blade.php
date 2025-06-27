<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Voorraad') }}
        </h2>
    </x-slot>

    @php
        $showForm = old('_show_form') || $errors->any() || request('_show_form');
    @endphp

    @if($showForm)
        <div class="flex items-center justify-center min-h-[60vh]">
            <div class="w-full max-w-lg bg-white p-8 rounded shadow border border-gray-200">
                <h3 class="text-xl font-semibold mb-6">Nieuw product toevoegen</h3>
                <form method="POST" action="{{ route('voorraad.toevoegen') }}">
                    @csrf
                    <input type="hidden" name="_show_form" value="1" />
                    <div class="mb-4">
                        <label for="streepjescode" class="block font-medium">Streepjescode</label>
                        <input type="text" name="streepjescode" id="streepjescode" value="{{ old('streepjescode') }}" class="w-full border rounded px-3 py-2 mt-1" required>
                        @error('streepjescode')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="naam" class="block font-medium">Productnaam</label>
                        <input type="text" name="naam" id="naam" value="{{ old('naam') }}" class="w-full border rounded px-3 py-2 mt-1" required>
                        @error('naam')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="categorie" class="block font-medium">Categorie</label>
                        <input type="text" name="categorie" id="categorie" value="{{ old('categorie') }}" class="w-full border rounded px-3 py-2 mt-1" required>
                        @error('categorie')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="aantal" class="block font-medium">Aantal</label>
                        <input type="number" name="aantal" id="aantal" value="{{ old('aantal') }}" class="w-full border rounded px-3 py-2 mt-1" min="1" required>
                        @error('aantal')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex justify-between">
                        <a href="{{ route('voorraad') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Annuleren</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6 text-lg font-semibold">
                            Dit is voorraad van alle producten
                        </div>

                        {{-- Succes- en foutmeldingen --}}
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Knop om formulier te tonen --}}
                        <form method="GET" action="{{ route('voorraad') }}">
                            <input type="hidden" name="_show_form" value="1" />
                            <button type="submit" class="mb-6 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Product toevoegen
                            </button>
                        </form>

                        <div class="overflow-x-auto">
                            @php
                                // Voorbeeld: vervang dit door echte data uit de controller
                                $producten = $producten ?? [
                                    ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120],
                                    ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80],
                                    ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45],
                                ];
                            @endphp

                            @if(empty($producten))
                                <div class="p-4 text-center text-gray-600">
                                    Er zijn momenteel geen producten in de voorraad beschikbaar.
                                </div>
                            @else
                            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">Streepjescode</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">Productnaam</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">Categorie</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">Aantal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($producten as $product)
                                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition-colors">
                                        <td class="px-6 py-3 border-b border-gray-200">{{ $product['streepjescode'] }}</td>
                                        <td class="px-6 py-3 border-b border-gray-200">{{ $product['naam'] }}</td>
                                        <td class="px-6 py-3 border-b border-gray-200">{{ $product['categorie'] }}</td>
                                        <td class="px-6 py-3 border-b border-gray-200">{{ $product['aantal'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
