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
            'klant_id' => 'nullable|exists:klanten,id',
            'datum_samenstelling' => 'required|date|after_or_equal:today',
            'datum_uitgifte' => 'nullable|date',
        ], [
            'datum_samenstelling.after_or_equal' => 'De datum van samenstelling mag niet vóór vandaag zijn.',
        ]);

        // Bepaal het volgende nummer
        $maxNummer = \App\Models\Voedselpakket::max('nummer');
        $volgendNummer = $maxNummer ? $maxNummer + 1 : 1;

        $data = $request->all();
        $data['nummer'] = $volgendNummer;

        \App\Models\Voedselpakket::create($data);

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
            'klant_id' => 'nullable|exists:klanten,id',
            'datum_samenstelling' => 'required|date|after_or_equal:today',
            'datum_uitgifte' => 'nullable|date',
            // Voeg hier validatie toe voor producten indien van toepassing
        ], [
            'datum_samenstelling.after_or_equal' => 'De datum van samenstelling mag niet vóór vandaag zijn.',
        ]);

        $data = $request->all();
        // Als klant_id leeg is, zet het expliciet op null
        if (!array_key_exists('klant_id', $data) || $data['klant_id'] === '' || $data['klant_id'] === null) {
            $data['klant_id'] = null;
        }

        $voedselpakket->update($data);

        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket bijgewerkt.');
    }

    public function destroy(Voedselpakket $voedselpakket)
    {
        $voedselpakket->delete();
        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket verwijderd.');
    }
}
        

       



