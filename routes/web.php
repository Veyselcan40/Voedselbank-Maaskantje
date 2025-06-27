<?php

use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VoedselpakketController;

Route::resource('voedselpakketten', VoedselpakketController::class);


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
    Route::get('/leverancier', [LeverancierController::class, 'index'])->name('leverancier.index');
    Route::get('/leverancier/create', [LeverancierController::class, 'create'])->name('leverancier.create');
    Route::post('/leverancier', [LeverancierController::class, 'store'])->name('leverancier.store');
    Route::get('/leverancier/{leverancier}/edit', [LeverancierController::class, 'edit'])->name('leverancier.edit');
    Route::put('/leverancier/{leverancier}', [LeverancierController::class, 'update'])->name('leverancier.update');
    Route::delete('/leverancier/{leverancier}', [LeverancierController::class, 'destroy'])->name('leverancier.destroy');
});

require __DIR__.'/auth.php';
