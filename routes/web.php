<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\VoedselpakketController;

Route::resource('voedselpakket', VoedselpakketController::class);
Route::get('/voedselpakketten', [VoedselpakketController::class, 'index'])->name('voedselpakketten.index');
Route::get('/voedselpakketten/create', [VoedselpakketController::class, 'create'])->name('voedselpakketten.create');
Route::post('/voedselpakketten', [VoedselpakketController::class, 'store'])->name('voedselpakketten.store');
Route::get('/voedselpakketten/{id}/edit', [VoedselpakketController::class, 'edit'])->name('voedselpakketten.edit');
Route::put('/voedselpakketten/{id}', [VoedselpakketController::class, 'update'])->name('voedselpakketten.update');
Route::delete('/voedselpakketten/{id}', [VoedselpakketController::class, 'destroy'])->name('voedselpakketten.destroy');

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
    $klanten = array_merge($dummyKlanten, $sessionKlanten);
    return view('klantenoverzicht', compact('klanten'));
})->name('klantenoverzicht');

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
