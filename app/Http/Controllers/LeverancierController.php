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
            $leveranciers = \App\Models\Leverancier::orderByRaw('
                CASE WHEN EerstvolgendeLevering IS NULL THEN 0 ELSE 1 END,
                EerstvolgendeLevering DESC
            ')->paginate(6);

            return view('leverancier.index', compact('leveranciers'));
        } catch (\Exception $e) {
            return view('leverancier.index', ['leveranciers' => collect()])
                ->with('error', 'Er is een fout opgetreden bij het laden van de leveranciers.');
        }
    }
   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('leverancier.create');
        } catch (\Exception $e) {
            return redirect()->route('leverancier.index')
                ->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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
                'Leverancierstype' => 'required|in:groothandel,supermarkt,boeren',
                'Actief' => 'required|boolean',
            ], [
                'Email.unique' => 'Een leverancier met dit e-mailadres bestaat al.',
            ]);

            Leverancier::create($validated);

            return redirect()->route('leverancier.index')->with('success', 'Leverancier succesvol toegevoegd.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Er is een fout opgetreden bij het toevoegen van de leverancier.')
                ->withInput();
        }
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
        try {
            return view('leverancier.edit', compact('leverancier'));
        } catch (\Exception $e) {
            return redirect()->route('leverancier.index')
                ->with('error', 'Er is een fout opgetreden bij het laden van het bewerkingsformulier.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leverancier $leverancier)
    {
        try {
            $validated = $request->validate([
                'Bedrijfsnaam' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:leveranciers,Bedrijfsnaam,' . $leverancier->id,
                ],
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
                'Leverancierstype' => 'required|in:groothandel,supermarkt,boeren',
                'Actief' => 'required|boolean',
            ], [
                'Bedrijfsnaam.unique' => 'Deze bedrijfsnaam bestaat al.',
                'Email.email' => 'Voer een geldig e-mailadres in.',
                'Email.unique' => 'Een leverancier met dit e-mailadres bestaat al.',
                'Telefoon.regex' => 'Voer een telefoonnummer in van minimaal 8 en maximaal 12 cijfers.',
            ]);

            $leverancier->update($validated);

            return redirect()->route('leverancier.index')->with('success', 'Leverancier succesvol bijgewerkt.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van de leverancier.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leverancier $leverancier)
    {
        try {
            $leverancier->delete();
            return redirect()->route('leverancier.index')->with('success', 'Leverancier succesvol verwijderd.');
        } catch (\Exception $e) {
            return redirect()->route('leverancier.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van de leverancier.');
        }
    }
};



