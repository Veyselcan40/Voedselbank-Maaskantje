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
            $leveranciers = Leverancier::all();
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
            'Email' => 'required|email|max:255',
            'Telefoon' => ['required', 'regex:/^[0-9]+$/', 'max:255'],
            'EerstvolgendeLevering' => 'nullable|date',
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
            'Email' => 'required|email|max:255',
            'Telefoon' => ['required', 'regex:/^[0-9]+$/', 'max:255'],
            'EerstvolgendeLevering' => 'nullable|date',
        ]);

        $leverancier->update($validated);

        return redirect()->route('leverancier.index')->with('success', 'Leverancier succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
