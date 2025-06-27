<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Klant;

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

Route::get('/klantenoverzicht', function () {
    if (\App\Models\Klant::count() === 0) {
        \App\Models\Klant::insert([
            [
                'naam' => 'Familie Jansen',
                'adres' => 'Dorpsstraat 1, 1234 AB Plaats',
                'telefoon' => '0612345678',
                'email' => 'jansen@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Familie De Vries',
                'adres' => 'Hoofdweg 10, 5678 CD Stad',
                'telefoon' => '0687654321',
                'email' => 'devries@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Familie Bakker',
                'adres' => 'Kerklaan 5, 4321 EF Dorp',
                'telefoon' => '0622334455',
                'email' => 'bakker@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
    $klanten = Klant::all();
    return view('klantenoverzicht', compact('klanten'));
})->name('klantenoverzicht');

Route::get('/klanten/{id}/bewerken', function ($id) {
    $klant = Klant::findOrFail($id);
    return view('klanten_bewerken', compact('klant'));
})->name('klanten.bewerken');

Route::post('/klanten/{id}/bewerken', function (Request $request, $id) {
    $request->validate([
        'naam' => 'required|string|max:255',
        'adres' => 'required|string|max:255',
        'telefoon' => 'required|string|max:20',
        'email' => 'required|email|max:255',
    ]);
    $klant = Klant::findOrFail($id);
    $klant->update([
        'naam' => $request->naam,
        'adres' => $request->adres,
        'telefoon' => $request->telefoon,
        'email' => $request->email,
    ]);
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
    Klant::create([
        'naam' => $request->naam,
        'adres' => $request->adres,
        'telefoon' => $request->telefoon,
        'email' => $request->email,
    ]);
    return redirect()->route('klantenoverzicht')->with('success', 'Nieuwe klant succesvol geregistreerd.');
})->name('klanten.nieuw.post');

Route::delete('/klanten/{id}/verwijderen', function ($id) {
    $klant = Klant::findOrFail($id);
    $klant->delete();
    return redirect()->route('klantenoverzicht')->with('success', 'Klant succesvol verwijderd.');
})->name('klanten.verwijderen');

require __DIR__.'/auth.php';
