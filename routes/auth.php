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
        $producten = session('producten', [
            ['streepjescode' => '8712345678901', 'naam' => 'Pasta', 'categorie' => 'Voedsel', 'aantal' => 120, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678902', 'naam' => 'Rijst', 'categorie' => 'Voedsel', 'aantal' => 80, 'verwijderbaar' => true],
            ['streepjescode' => '8712345678903', 'naam' => 'Shampoo', 'categorie' => 'Verzorging', 'aantal' => 45, 'verwijderbaar' => true],
        ]);

        $validated = $request->validate([
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'aantal' => ['required', 'integer', 'min:1'],
        ]);

        // Controleer op unieke naam (optioneel, mag je ook weglaten)
        foreach ($producten as $product) {
            if (strtolower($product['naam']) === strtolower($validated['naam'])) {
                return redirect()->route('voorraad')
                    ->withInput()
                    ->withErrors(['naam' => 'Een product met deze naam bestaat al in de voorraad.'])
                    ->with('error', 'Een product met deze naam bestaat al in de voorraad.');
            }
        }

        // Voeg nieuw product toe via Eloquent:
        \App\Models\Product::create([
            'naam' => $validated['naam'],
            'categorie' => $validated['categorie'],
            'aantal' => $validated['aantal'],
            // 'streepjescode' wordt automatisch gegenereerd
        ]);

        return redirect()->route('voorraad')->with('success', 'Product succesvol toegevoegd.');
    })->name('voorraad.toevoegen');

    // Functies voor bewerken en verwijderen (voorraadbeheer)
    Route::get('voorraad/bewerk/{streepjescode}', function ($streepjescode) {
        // Haal producten uit de database
        $producten = \App\Models\Product::all();
        $product = $producten->firstWhere('streepjescode', $streepjescode);
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
        // Haal producten uit de database
        $product = \App\Models\Product::where('streepjescode', $streepjescode)->first();
        if (!$product) {
            return redirect()->route('voorraad')->with('error', 'Product niet gevonden.');
        }

        $validated = $request->validate([
            'streepjescode' => ['required', 'string', 'max:255'],
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'aantal' => ['required', 'integer', 'min:1'],
        ]);

        // Controleer op dubbele streepjescode of naam bij andere producten
        $exists = \App\Models\Product::where('id', '!=', $product->id)
            ->where(function($q) use ($validated) {
                $q->where('streepjescode', $validated['streepjescode'])
                  ->orWhereRaw('LOWER(naam) = ?', [strtolower($validated['naam'])]);
            })
            ->exists();

        if ($exists) {
            return redirect()->route('voorraad.bewerk', $streepjescode)
                ->withInput()
                ->withErrors(['streepjescode' => 'Er bestaat al een product met deze streepjescode of productnaam.'])
                ->with('error', 'Er bestaat al een product met deze streepjescode of productnaam.');
        }

        // Werk het product bij
        $product->update([
            'streepjescode' => $validated['streepjescode'],
            'naam' => $validated['naam'],
            'categorie' => $validated['categorie'],
            'aantal' => $validated['aantal'],
        ]);

        return redirect()->route('voorraad')->with('success', 'Product succesvol bijgewerkt.');
    })->name('voorraad.bewerk.opslaan');

    // Wijzig deze route van DELETE naar POST zodat het werkt met standaard HTML forms
    Route::post('voorraad/verwijder/{streepjescode}', function ($streepjescode) {
        // Haal het product uit de database
        $product = \App\Models\Product::where('streepjescode', $streepjescode)->first();

        if (!$product) {
            return redirect()->route('voorraad')->with('error', 'Product niet gevonden.');
        }

        // Controle: zit het product in een voedselpakket?
        $zitInPakket = \DB::table('voedselpakket_product')->where('product_id', $product->id)->exists();
        if ($zitInPakket) {
            return redirect()->route('voorraad')->with('error', 'Product kan niet verwijderd worden.');
        }

        $product->delete();

        return redirect()->route('voorraad')->with('success', 'Product succesvol verwijderd.');
    })->name('voorraad.verwijder');
});