<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\VoedselpakketController;
use App\Models\Klant;

Route::get('/voedselpakketten', [VoedselpakketController::class, 'index'])->name('voedselpakketten.index');
Route::get('/voedselpakketten/create', [VoedselpakketController::class, 'create'])->name('voedselpakketten.create');
Route::post('/voedselpakketten', [VoedselpakketController::class, 'store'])->name('voedselpakketten.store');
Route::get('/voedselpakketten/{voedselpakket}/edit', [VoedselpakketController::class, 'edit'])->name('voedselpakketten.edit');
Route::put('/voedselpakketten/{voedselpakket}', [VoedselpakketController::class, 'update'])->name('voedselpakketten.update');
Route::delete('/voedselpakketten/{voedselpakket}', [VoedselpakketController::class, 'destroy'])->name('voedselpakketten.destroy');

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
    $klanten = \App\Models\Klant::all();
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
        'telefoon' => [
            'required',
            'digits_between:10,12'
        ],
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
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:klanten,email',
        ],
    ], [
        'email.unique' => 'Een klant met dit e-mailadres bestaat al.',
    ]);

    // Sla klant direct op in de database
    \App\Models\Klant::create([
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
