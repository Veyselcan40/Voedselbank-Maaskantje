<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leverancier; // <-- toegevoegd

class LeverancierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $leveranciers = Leverancier::paginate(6);
            return view('leverancier.index', compact('leveranciers'));
        } catch (\Exception $e) {
            return view('leverancier.index')->withErrors('Op dit moment kunnen de leveranciersgegevens niet worden geladen. Probeer het later opnieuw.');
        }
    }
   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leverancier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Bedrijfsnaam' => 'required|string|max:255',
            'Adres' => 'required|string|max:255',
            'Contactpersoon' => 'required|string|max:255',
            'Email' => [
                'required',
                'email',
                'max:255',
                'unique:leveranciers,Email',
            ],
            'Telefoon' => ['required', 'regex:/^[0-9]+$/', 'max:255'],
            'EerstvolgendeLevering' => 'nullable|date',
        ], [
            'Email.unique' => 'Een leverancier met dit e-mailadres bestaat al.',
        ]);

        Leverancier::create($validated);

        return redirect()->route('leverancier.index')->with('success', 'Leverancier succesvol toegevoegd.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leverancier $leverancier)
    {
        return view('leverancier.edit', compact('leverancier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leverancier $leverancier)
    {
        $validated = $request->validate([
            'Bedrijfsnaam' => 'required|string|max:255',
            'Adres' => 'required|string|max:255',
            'Contactpersoon' => 'required|string|max:255',
            'Email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:leveranciers,Email,' . $leverancier->id,
            ],
            'Telefoon' => [
                'required',
                'regex:/^[0-9]{8,12}$/',
                'max:12'
            ],
            'EerstvolgendeLevering' => 'nullable|date',
        ], [
            'Email.email' => 'Voer een geldig e-mailadres in.',
            'Email.unique' => 'Een leverancier met dit e-mailadres bestaat al.',
            'Telefoon.regex' => 'Voer een telefoonnummer in van minimaal 8 en maximaal 12 cijfers.',
        ]);

        $leverancier->update($validated);

        return redirect()->route('leverancier.index')->with('success', 'Leverancier succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leverancier $leverancier)
    {
        $leverancier->delete();
        return redirect()->route('leverancier.index')->with('success', 'Leverancier succesvol verwijderd.');
    }
}

