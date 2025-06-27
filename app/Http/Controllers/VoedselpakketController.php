<?php

namespace App\Http\Controllers;

use App\Models\Voedselpakket;
use App\Models\Klant;
use Illuminate\Http\Request;


class VoedselpakketController extends Controller
{
    public function index()
    {
        $voedselpakketten = Voedselpakket::with('klant')->paginate(10);
        return view('voedselpakket.index', compact('voedselpakketten'));
    }

    public function create()
    {
        $klanten = Klant::all(); // haalt alle klanten uit de database
        return view('voedselpakket.create', compact('klanten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klant_id' => 'required|exists:klanten,id',
            'datum_samenstelling' => 'required|date',
            'datum_uitgifte' => 'nullable|date',
        ]);

        Voedselpakket::create($request->all());

        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket toegevoegd.');
    }

    public function show(Voedselpakket $voedselpakket)
    {
        return view('voedselpakket.show', compact('voedselpakket'));
    }

    public function edit(Voedselpakket $voedselpakket)
    {
        $klanten = Klant::all(); // haalt alle klanten uit de database
        return view('voedselpakket.edit', compact('voedselpakket', 'klanten'));
    }

    public function update(Request $request, Voedselpakket $voedselpakket)
    {
        $request->validate([
            'klant_id' => 'required|exists:klanten,id',
            'datum_samenstelling' => 'required|date',
            'datum_uitgifte' => 'nullable|date',
            // Voeg hier validatie toe voor producten indien van toepassing
        ], [
            'klant_id.required' => 'Een voedselpakket moet altijd gekoppeld zijn aan een klant.',
            'klant_id.exists' => 'De geselecteerde klant bestaat niet.',
        ]);

        // Placeholder: voorraad aanpassen als producten zijn gewijzigd
        // if ($productenGewijzigd) {
        //     Pas de voorraad aan...
        // }

        $voedselpakket->update($request->all());

        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket bijgewerkt.');
    }

    public function destroy(Voedselpakket $voedselpakket)
    {
        $voedselpakket->delete();
        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket verwijderd.');
    }
}
