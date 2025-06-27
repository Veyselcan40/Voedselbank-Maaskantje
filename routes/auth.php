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
        // Alle producten zijn nu verwijderbaar
        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45, 'verwijderbaar' => true],
        ]);

        // Filteren
        $zoekStreep = $request->input('zoek_streepjescode', '');
        $zoekCategorie = $request->input('zoek_categorie', '');
        if ($zoekStreep) {
            $producten = array_filter($producten, fn($p) => str_contains($p['streepjescode'], $zoekStreep));
        }
        if ($zoekCategorie) {
            $producten = array_filter($producten, fn($p) => $p['categorie'] === $zoekCategorie);
        }
        // Sorteren
        $sort = $request->input('sort', 'streepjescode');
        $direction = $request->input('direction', 'asc');
        usort($producten, function($a, $b) use ($sort, $direction) {
            $res = $a[$sort] <=> $b[$sort];
            return $direction === 'desc' ? -$res : $res;
        });

        return view('voorraad', compact('producten', 'categorieen', 'sort', 'direction', 'zoekStreep', 'zoekCategorie'));
    })->name('voorraad');

    Route::post('voorraad/toevoegen', function (\Illuminate\Http\Request $request) {
        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => true],
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
        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45, 'verwijderbaar' => true],
        ]);
        $product = null;
        foreach ($producten as $p) {
            if ($p['streepjescode'] === $streepjescode) {
                $product = $p;
                break;
            }
        }
        if (!$product) {
            return redirect()->route('voorraad')->with('error', 'Product niet gevonden.');
        }
        $categorieen = ['Voedsel', 'Verzorging', 'Drinken', 'Overig'];
        // Toon het wijzigformulier, geef het product en categorieën door
        return view('voorraad', [
            'bewerkProduct' => $product,
            'categorieen' => $categorieen,
            'producten' => $producten,
            'showEditForm' => true,
        ]);
    })->name('voorraad.bewerk');

    Route::post('voorraad/bewerk/{streepjescode}', function (\Illuminate\Http\Request $request, $streepjescode) {
        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45, 'verwijderbaar' => true],
        ]);

        $validated = $request->validate([
            'streepjescode' => ['required', 'string', 'max:255'],
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'aantal' => ['required', 'integer', 'min:1'],
        ]);

        // Zoek het huidige product
        $huidigIndex = null;
        foreach ($producten as $key => $product) {
            if ($product['streepjescode'] === $streepjescode) {
                $huidigIndex = $key;
                break;
            }
        }
        if ($huidigIndex === null) {
            return redirect()->route('voorraad')->with('error', 'Product niet gevonden.');
        }

        // Controleer op dubbele streepjescode of naam bij andere producten
        foreach ($producten as $key => $product) {
            if ($key === $huidigIndex) continue;
            if ($product['streepjescode'] === $validated['streepjescode'] || strtolower($product['naam']) === strtolower($validated['naam'])) {
                return redirect()->route('voorraad.bewerk', $streepjescode)
                    ->withInput()
                    ->withErrors(['streepjescode' => 'Er bestaat al een product met deze streepjescode of productnaam.'])
                    ->with('error', 'Er bestaat al een product met deze streepjescode of productnaam.');
            }
        }

        // Werk het product bij
        $producten[$huidigIndex] = [
            'streepjescode' => $validated['streepjescode'],
            'naam' => $validated['naam'],
            'categorie' => $validated['categorie'],
            'aantal' => $validated['aantal'],
            'verwijderbaar' => true,
        ];
        session(['producten' => $producten]);

        return redirect()->route('voorraad')->with('success', 'Product succesvol bijgewerkt.');
    })->name('voorraad.bewerk.opslaan');

    // Wijzig deze route van DELETE naar POST zodat het werkt met standaard HTML forms
    Route::post('voorraad/verwijder/{streepjescode}', function ($streepjescode) {
        // Simuleer database lookup: zoek het product in de sessie
        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45, 'verwijderbaar' => true],
        ]);

        // Simuleer voedselpakket-producten relatie (in echte app: pivot-tabel)
        // Voorbeeld: [['pakket_id'=>1, 'streepjescode'=>'8712345678901'], ...]
        $voedselpakket_producten = session('voedselpakket_producten', [
            ['pakket_id' => 1, 'streepjescode' => '8712345678901'],
            // Voeg meer toe indien gewenst
        ]);

        // Controle: zit het product in een voedselpakket?
        $zitInPakket = false;
        foreach ($voedselpakket_producten as $relatie) {
            if ($relatie['streepjescode'] === $streepjescode) {
                $zitInPakket = true;
                break;
            }
        }
        if ($zitInPakket) {
            // Foutmelding tonen, product blijft zichtbaar
            return redirect()->route('voorraad')->with('error', 'Product kan niet verwijderd worden.');
        }

        // Zoek het product
        $gevonden = false;
        foreach ($producten as $key => $product) {
            if ($product['streepjescode'] === $streepjescode) {
                $gevonden = true;
                unset($producten[$key]);
                session(['producten' => array_values($producten)]);
                return redirect()->route('voorraad')->with('success', 'Product succesvol verwijderd.');
            }
        }
        // Product niet gevonden
        return redirect()->route('voorraad')->with('error', 'Product niet gevonden.');
    })->name('voorraad.verwijder');
});