<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/klantenoverzicht', function (Request $request) {
    $dummyKlanten = [
        [
            'naam' => 'Familie Jansen',
            'adres' => 'Dorpsstraat 1, 1234 AB Plaats',
            'telefoon' => '0612345678',
            'email' => 'jansen@email.com',
        ],
        [
            'naam' => 'Familie De Vries',
            'adres' => 'Hoofdweg 10, 5678 CD Stad',
            'telefoon' => '0687654321',
            'email' => 'devries@email.com',
        ],
        [
            'naam' => 'Familie Bakker',
            'adres' => 'Kerklaan 5, 4321 EF Dorp',
            'telefoon' => '0622334455',
            'email' => 'bakker@email.com',
        ],
    ];
    $sessionKlanten = $request->session()->get('extra_klanten', []);
    $sessionKlanten = array_values($sessionKlanten); // Zorg voor juiste indexen
    $klanten = array_merge($dummyKlanten, $sessionKlanten);
    return view('klantenoverzicht', compact('klanten'));
})->name('klantenoverzicht');

Route::get('/klanten/{index}/bewerken', function (Request $request, $index) {
    $dummyKlanten = [
        [
            'naam' => 'Familie Jansen',
            'adres' => 'Dorpsstraat 1, 1234 AB Plaats',
            'telefoon' => '0612345678',
            'email' => 'jansen@email.com',
        ],
        [
            'naam' => 'Familie De Vries',
            'adres' => 'Hoofdweg 10, 5678 CD Stad',
            'telefoon' => '0687654321',
            'email' => 'devries@email.com',
        ],
        [
            'naam' => 'Familie Bakker',
            'adres' => 'Kerklaan 5, 4321 EF Dorp',
            'telefoon' => '0622334455',
            'email' => 'bakker@email.com',
        ],
    ];
    $sessionKlanten = $request->session()->get('extra_klanten', []);
    $sessionKlanten = array_values($sessionKlanten);
    $klanten = array_merge($dummyKlanten, $sessionKlanten);

    if (!isset($klanten[$index])) {
        abort(404);
    }
    $klant = $klanten[$index];
    $isDummy = $index < count($dummyKlanten);
    return view('klanten_bewerken', compact('klant', 'index', 'isDummy'));
})->name('klanten.bewerken');

Route::post('/klanten/{index}/bewerken', function (Request $request, $index) {
    $request->validate([
        'naam' => 'required|string|max:255',
        'adres' => 'required|string|max:255',
        'telefoon' => 'required|string|max:20',
        'email' => 'required|email|max:255',
    ]);
    $dummyCount = 3;
    if ($index < $dummyCount) {
        // Dummy klanten kunnen niet echt gewijzigd worden, maar we simuleren het voor demo
        // Optioneel: sla wijzigingen tijdelijk op in session (voor demo)
        $dummyEdits = $request->session()->get('dummy_edits', []);
        $dummyEdits[$index] = [
            'naam' => $request->naam,
            'adres' => $request->adres,
            'telefoon' => $request->telefoon,
            'email' => $request->email,
        ];
        $request->session()->put('dummy_edits', $dummyEdits);
    } else {
        $sessionKlanten = $request->session()->get('extra_klanten', []);
        $sessionKlanten = array_values($sessionKlanten);
        $sessionIndex = $index - $dummyCount;
        if (isset($sessionKlanten[$sessionIndex])) {
            $sessionKlanten[$sessionIndex] = [
                'naam' => $request->naam,
                'adres' => $request->adres,
                'telefoon' => $request->telefoon,
                'email' => $request->email,
            ];
            $request->session()->put('extra_klanten', $sessionKlanten);
        }
    }
    return redirect()->route('klantenoverzicht')->with('success', 'Klantgegevens succesvol gewijzigd.');
})->name('klanten.bewerken.post');

Route::get('/klanten/nieuw', function () {
    return view('klanten_nieuw');
})->name('klanten.nieuw');

Route::post('/klanten/nieuw', function (Request $request) {
    $request->validate([
        'naam' => 'required|string|max:255',
        'adres' => 'required|string|max:255',
        'telefoon' => 'required|string|max:20',
        'email' => 'required|email|max:255',
    ]);
    $klant = [
        'naam' => $request->naam,
        'adres' => $request->adres,
        'telefoon' => $request->telefoon,
        'email' => $request->email,
    ];
    $extraKlanten = $request->session()->get('extra_klanten', []);
    $extraKlanten[] = $klant;
    $request->session()->put('extra_klanten', $extraKlanten);
    return redirect()->route('klantenoverzicht')->with('success', 'Nieuwe klant succesvol geregistreerd.');
})->name('klanten.nieuw.post');

require __DIR__.'/auth.php';
