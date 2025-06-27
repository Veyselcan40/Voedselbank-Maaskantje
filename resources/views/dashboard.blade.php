<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight tracking-tight">
            {{ __('Welkom bij de Voedselbank Maaskantje') }}
        </h2>
    </x-slot>

    <div class="relative min-h-[60vh] flex items-center justify-center overflow-hidden bg-gray-900">
        {{-- Video achtergrond, fallback naar afbeelding als video niet werkt --}}
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="https://www.w3schools.com/howto/rain.mp4" type="video/mp4">
            <!-- Fallback afbeelding -->
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80" alt="Voedselbank" class="w-full h-full object-cover">
        </video>
        <div class="absolute inset-0 bg-black bg-opacity-60 z-10"></div>
        <div class="relative z-20 flex flex-col items-center justify-center text-center px-4 py-24">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 drop-shadow-lg">
                Samen tegen voedselverspilling & armoede
            </h1>
            <p class="text-xl md:text-2xl text-gray-100 mb-8 max-w-2xl drop-shadow">
                De Voedselbank Maaskantje helpt mensen in nood met voedselpakketten en strijdt tegen verspilling. 
                <br>
                <span class="font-semibold">Iedereen verdient een volle tafel.</span>
            </p>
            <a href="{{ route('voorraad') }}" class="inline-block px-8 py-4 bg-green-600 text-white text-lg font-bold rounded-lg shadow-lg hover:bg-green-700 transition">
                Bekijk de voorraad
            </a>
        </div>
    </div>
</x-app-layout>
