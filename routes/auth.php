<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('voorraad', function (\Illuminate\Http\Request $request) {
        $categorieen = ['Voedsel', 'Verzorging', 'Drinken', 'Overig'];
        // Haal producten uit de database in plaats van uit de sessie
        $producten = \App\Models\Product::all();

        // Filteren
        $zoekStreep = $request->input('zoek_streepjescode', '');
        $zoekCategorie = $request->input('zoek_categorie', '');
        if ($zoekStreep) {
            $producten = $producten->filter(fn($p) => str_contains($p->streepjescode, $zoekStreep));
        }
        if ($zoekCategorie) {
            $producten = $producten->filter(fn($p) => $p->categorie === $zoekCategorie);
        }
        // Sorteren
        $sort = $request->input('sort', 'streepjescode');
        $direction = $request->input('direction', 'asc');
        $producten = $producten->sortBy($sort, SORT_REGULAR, $direction === 'desc');

        return view('voorraad', [
            'producten' => $producten,
            'categorieen' => $categorieen,
            'sort' => $sort,
            'direction' => $direction,
            'zoekStreep' => $zoekStreep,
            'zoekCategorie' => $zoekCategorie,
        ]);
    })->name('voorraad');

    Route::post('voorraad/toevoegen', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'streepjescode' => ['required', 'string', 'max:255', 'unique:producten,streepjescode'],
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'aantal' => ['required', 'integer', 'min:1'],
        ]);
        \App\Models\Product::create($validated);
        return redirect()->route('voorraad')->with('success', 'Product succesvol toegevoegd.');
    })->name('voorraad.toevoegen');

    Route::get('voorraad/bewerk/{streepjescode}', function ($streepjescode) {
        $product = \App\Models\Product::where('streepjescode', $streepjescode)->firstOrFail();
        $categorieen = ['Voedsel', 'Verzorging', 'Drinken', 'Overig'];
        $producten = \App\Models\Product::orderBy('streepjescode')->get()->toArray();
        return view('voorraad', [
            'bewerkProduct' => $product->toArray(),
            'categorieen' => $categorieen,
            'producten' => $producten,
            'showEditForm' => true,
        ]);
    })->name('voorraad.bewerk');

    Route::post('voorraad/bewerk/{streepjescode}', function (\Illuminate\Http\Request $request, $streepjescode) {
        $product = \App\Models\Product::where('streepjescode', $streepjescode)->firstOrFail();
        $validated = $request->validate([
            'streepjescode' => ['required', 'string', 'max:255', 'unique:producten,streepjescode,' . $product->id],
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'aantal' => ['required', 'integer', 'min:1'],
        ]);
        $product->update($validated);
        return redirect()->route('voorraad')->with('success', 'Product succesvol bijgewerkt.');
    })->name('voorraad.bewerk.opslaan');

    Route::post('voorraad/verwijder/{streepjescode}', function ($streepjescode) {
        $product = \App\Models\Product::where('streepjescode', $streepjescode)->first();
        if (!$product) {
            return redirect()->route('voorraad')->with('error', 'Product niet gevonden.');
        }
        // Controle: zit het product in een voedselpakket?
        $heeftPakket = $product->voedselpakketten()->exists();
        if ($heeftPakket) {
            return redirect()->route('voorraad')->with('error', 'Product kan niet verwijderd worden.');
        }
        $product->delete();
        return redirect()->route('voorraad')->with('success', 'Product succesvol verwijderd.');
    })->name('voorraad.verwijder');
});