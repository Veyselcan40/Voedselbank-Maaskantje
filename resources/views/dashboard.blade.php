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
        <div class="relative z-20 flex flex-col items-center justify-center text-center px-4 py-24 w-full">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 drop-shadow-lg">
                Samen tegen voedselverspilling & armoede
            </h1>
            <p class="text-xl md:text-2xl text-gray-100 mb-8 max-w-2xl drop-shadow">
                De Voedselbank Maaskantje helpt mensen in nood met voedselpakketten en strijdt tegen verspilling. 
                <br>
                <span class="font-semibold">Iedereen verdient een volle tafel.</span>
            </p>
            {{-- Nieuwe futuristische dashboard cards --}}
            <div class="w-full max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                <!-- Voorraadbeheer Card -->
                <a href="{{ route('voorraad') }}" class="group relative rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl p-8 flex flex-col items-center transition hover:scale-105 hover:bg-white/20 hover:border-blue-400 duration-300 overflow-hidden">
                    <div class="absolute -top-12 right-0 left-0 flex justify-center pointer-events-none">
                        <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" alt="Voorraad" class="w-24 h-24 drop-shadow-xl group-hover:scale-110 transition" />
                    </div>
                    <div class="mt-16 mb-4">
                        <svg class="w-12 h-12 text-blue-400 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
                            <rect x="8" y="16" width="32" height="24" rx="6" stroke="currentColor" fill="none"/>
                            <path d="M16 16V12a8 8 0 0 1 16 0v4" stroke="currentColor"/>
                        </svg>
                    </div>
                    <div class="text-white text-xl font-bold mb-2">Voorraadbeheer</div>
                    <div class="text-blue-100 mb-4">Bekijk en beheer de actuele voorraad producten.</div>
                    <span class="inline-block px-4 py-2 rounded-full bg-blue-500/80 text-white font-semibold text-sm group-hover:bg-blue-600 transition">Naar voorraad</span>
                    <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-400/40 via-transparent to-blue-400/40 rounded-b-3xl"></div>
                </a>
                <!-- Laravel Docs Card -->
                <a href="https://laravel.com/docs" target="_blank" class="group relative rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl p-8 flex flex-col items-center transition hover:scale-105 hover:bg-white/20 hover:border-red-400 duration-300 overflow-hidden">
                    <div class="absolute -top-12 right-0 left-0 flex justify-center pointer-events-none">
                        <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel" class="w-24 h-24 drop-shadow-xl group-hover:scale-110 transition" />
                    </div>
                    <div class="mt-16 mb-4">
                        <svg class="w-12 h-12 text-red-400 group-hover:text-red-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
                            <path d="M8 36V12l16-8 16 8v24l-16 8-16-8z" stroke="currentColor" fill="none"/>
                        </svg>
                    </div>
                    <div class="text-white text-xl font-bold mb-2">Laravel Docs</div>
                    <div class="text-red-100 mb-4">Lees de officiële Laravel documentatie.</div>
                    <span class="inline-block px-4 py-2 rounded-full bg-red-500/80 text-white font-semibold text-sm group-hover:bg-red-600 transition">Open Docs</span>
                    <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-red-400/40 via-transparent to-red-400/40 rounded-b-3xl"></div>
                </a>
                <!-- Laracasts Card -->
                <a href="https://laracasts.com" target="_blank" class="group relative rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl p-8 flex flex-col items-center transition hover:scale-105 hover:bg-white/20 hover:border-pink-400 duration-300 overflow-hidden">
                    <div class="absolute -top-12 right-0 left-0 flex justify-center pointer-events-none">
                        <img src="https://laracasts.com/images/logo.svg" alt="Laracasts" class="w-24 h-24 drop-shadow-xl group-hover:scale-110 transition" />
                    </div>
                    <div class="mt-16 mb-4">
                        <svg class="w-12 h-12 text-pink-400 group-hover:text-pink-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" fill="none"/>
                            <polygon points="20,16 34,24 20,32" fill="currentColor" class="opacity-80"/>
                        </svg>
                    </div>
                    <div class="text-white text-xl font-bold mb-2">Laracasts</div>
                    <div class="text-pink-100 mb-4">Bekijk video tutorials over Laravel en meer.</div>
                    <span class="inline-block px-4 py-2 rounded-full bg-pink-500/80 text-white font-semibold text-sm group-hover:bg-pink-600 transition">Bekijk Laracasts</span>
                    <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-pink-400/40 via-transparent to-pink-400/40 rounded-b-3xl"></div>
                </a>
                <!-- Cloud Deploy Card -->
                <a href="https://cloud.laravel.com" target="_blank" class="group relative rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl p-8 flex flex-col items-center transition hover:scale-105 hover:bg-white/20 hover:border-green-400 duration-300 overflow-hidden">
                    <div class="absolute -top-12 right-0 left-0 flex justify-center pointer-events-none">
                        <img src="https://cdn-icons-png.flaticon.com/512/4144/4144716.png" alt="Cloud" class="w-24 h-24 drop-shadow-xl group-hover:scale-110 transition" />
                    </div>
                    <div class="mt-16 mb-4">
                        <svg class="w-12 h-12 text-green-400 group-hover:text-green-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
                            <ellipse cx="24" cy="32" rx="16" ry="8" stroke="currentColor" fill="none"/>
                            <path d="M16 32V24a8 8 0 0 1 16 0v8" stroke="currentColor"/>
                        </svg>
                    </div>
                    <div class="text-white text-xl font-bold mb-2">Laravel Cloud</div>
                    <div class="text-green-100 mb-4">Deploy je Laravel app direct in de cloud.</div>
                    <span class="inline-block px-4 py-2 rounded-full bg-green-500/80 text-white font-semibold text-sm group-hover:bg-green-600 transition">Deploy nu</span>
                    <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-green-400/40 via-transparent to-green-400/40 rounded-b-3xl"></div>
                </a>
                <!-- Github Card -->
                <a href="https://github.com/Veyselcan40/Voedselbank-Maaskantje" target="_blank" class="group relative rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl p-8 flex flex-col items-center transition hover:scale-105 hover:bg-white/20 hover:border-gray-400 duration-300 overflow-hidden">
                    <div class="absolute -top-12 right-0 left-0 flex justify-center pointer-events-none">
                        <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="Github" class="w-24 h-24 drop-shadow-xl group-hover:scale-110 transition" />
                    </div>
                    <div class="mt-16 mb-4">
                        <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" fill="none"/>
                            <path d="M16 32c0-4 8-4 8 0v4" stroke="currentColor"/>
                        </svg>
                    </div>
                    <div class="text-white text-xl font-bold mb-2">GitHub</div>
                    <div class="text-gray-100 mb-4">Bekijk de code of open issues op GitHub.</div>
                    <span class="inline-block px-4 py-2 rounded-full bg-gray-700/80 text-white font-semibold text-sm group-hover:bg-gray-800 transition">Naar GitHub</span>
                    <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-gray-400/40 via-transparent to-gray-400/40 rounded-b-3xl"></div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>



