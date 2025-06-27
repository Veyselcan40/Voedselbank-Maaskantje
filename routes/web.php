<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    $klanten = [
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
    return view('klantenoverzicht', compact('klanten'));
})->name('klantenoverzicht');

require __DIR__.'/auth.php';
