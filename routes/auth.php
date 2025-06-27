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
        // Voorbeelddata, in echte app uit database
        $categorieen = ['Voedsel', 'Verzorging', 'Drinken', 'Overig'];
        $sort = $request->input('sort', 'streepjescode');
        $direction = $request->input('direction', 'asc');
        $zoekStreep = $request->input('zoek_streepjescode', '');
        $zoekCategorie = $request->input('zoek_categorie', '');

        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => false],
            ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45, 'verwijderbaar' => true],
        ]);

        // Filteren
        if ($zoekStreep) {
            $producten = array_filter($producten, fn($p) => str_contains($p['streepjescode'], $zoekStreep));
        }
        if ($zoekCategorie) {
            $producten = array_filter($producten, fn($p) => $p['categorie'] === $zoekCategorie);
        }
        // Sorteren
        usort($producten, function($a, $b) use ($sort, $direction) {
            $res = $a[$sort] <=> $b[$sort];
            return $direction === 'desc' ? -$res : $res;
        });

        return view('voorraad', compact('producten', 'categorieen', 'sort', 'direction', 'zoekStreep', 'zoekCategorie'));
    })->name('voorraad');

    Route::post('voorraad/toevoegen', function (\Illuminate\Http\Request $request) {
        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => false],
            ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45, 'verwijderbaar' => true],
        ]);

        $validated = $request->validate([
            'streepjescode' => ['required', 'string', 'max:255'],
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'aantal' => ['required', 'integer', 'min:1'],
        ]);

        // Controleer op unieke streepjescode
        foreach ($producten as $product) {
            if ($product['streepjescode'] === $validated['streepjescode']) {
                return redirect()->route('voorraad')
                    ->withInput()
                    ->withErrors(['streepjescode' => 'Een product met deze streepjescode bestaat al in de voorraad.'])
                    ->with('error', 'Een product met deze streepjescode bestaat al in de voorraad.');
            }
        }

        // Voeg nieuw product toe
        $producten[] = [
            'streepjescode' => $validated['streepjescode'],
            'naam' => $validated['naam'],
            'categorie' => $validated['categorie'],
            'aantal' => $validated['aantal'],
            'verwijderbaar' => true,
        ];
        session(['producten' => $producten]);

        return redirect()->route('voorraad')->with('success', 'Product succesvol toegevoegd.');
    })->name('voorraad.toevoegen');

    // Functies voor bewerken en verwijderen (voorraadbeheer)
    Route::get('voorraad/bewerk/{streepjescode}', function ($streepjescode) {
        // Hier zou je het product ophalen en een bewerk-formulier tonen
        // Voor nu: redirect terug met een melding
        return redirect()->route('voorraad')->with('error', 'Bewerken van producten is nog niet geïmplementeerd.');
    })->name('voorraad.bewerk');

    Route::delete('voorraad/verwijder/{streepjescode}', function ($streepjescode) {
        // Hier zou je het product verwijderen als het mag
        // Voor nu: redirect terug met een melding
        return redirect()->route('voorraad')->with('error', 'Verwijderen van producten is nog niet geïmplementeerd.');
    })->name('voorraad.verwijder');
});
