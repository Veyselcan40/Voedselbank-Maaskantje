<?php

namespace App\Http\Controllers;

use App\Models\Voedselpakket;
use App\Models\Klant;
use App\Models\Product;
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
        $klanten = Klant::all();
        // Alleen producten met voorraad > 0 tonen
        $producten = Product::where('aantal', '>', 0)->get();
        return view('voedselpakket.create', compact('klanten', 'producten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klant_id' => 'nullable|exists:klanten,id',
            'datum_samenstelling' => 'required|date|after_or_equal:today',
            'datum_uitgifte' => 'nullable|date',
            'producten' => 'nullable|array',
            'producten.*.id' => 'exists:producten,id',
            'producten.*.aantal' => 'nullable|integer|min:1',
        ], [
            'datum_samenstelling.after_or_equal' => 'De datum van samenstelling mag niet vóór vandaag zijn.',
        ]);

        // Bepaal het volgende nummer
        $maxNummer = \App\Models\Voedselpakket::max('nummer');
        $volgendNummer = $maxNummer ? $maxNummer + 1 : 1;

        $data = $request->all();
        $data['nummer'] = $volgendNummer;

        $pakket = \App\Models\Voedselpakket::create($data);

        // Koppel producten aan pakket
        if ($request->has('producten')) {
            $syncData = [];
            foreach ($request->input('producten') as $prod) {
                if (!empty($prod['id']) && !empty($prod['aantal'])) {
                    $syncData[$prod['id']] = ['aantal' => $prod['aantal']];
                }
            }
            $pakket->producten()->sync($syncData);
        }

        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket toegevoegd.');
    }

    public function show(Voedselpakket $voedselpakket)
    {
        return view('voedselpakket.show', compact('voedselpakket'));
    }

    public function edit(Voedselpakket $voedselpakket)
    {
        $klanten = Klant::all(); // haalt alle klanten uit de database
        $producten = Product::all();
        $geselecteerdeProducten = $voedselpakket->producten()->pluck('voedselpakket_product.aantal', 'producten.id')->toArray();
        return view('voedselpakket.edit', compact('voedselpakket', 'klanten', 'producten', 'geselecteerdeProducten'));
    }

    public function update(Request $request, Voedselpakket $voedselpakket)
    {
        $request->validate([
            'klant_id' => 'nullable|exists:klanten,id',
            'datum_samenstelling' => 'required|date|after_or_equal:today',
            'datum_uitgifte' => 'nullable|date',
            'producten' => 'nullable|array',
            'producten.*.id' => 'exists:producten,id',
            'producten.*.aantal' => 'nullable|integer|min:1',
        ], [
            'datum_samenstelling.after_or_equal' => 'De datum van samenstelling mag niet vóór vandaag zijn.',
        ]);

        $data = $request->all();
        if (!array_key_exists('klant_id', $data) || $data['klant_id'] === '' || $data['klant_id'] === null) {
            $data['klant_id'] = null;
        }

        $voedselpakket->update($data);

        // Koppel producten aan pakket
        if ($request->has('producten')) {
            $syncData = [];
            foreach ($request->input('producten') as $prod) {
                if (!empty($prod['id']) && !empty($prod['aantal'])) {
                    $syncData[$prod['id']] = ['aantal' => $prod['aantal']];
                }
            }
            $voedselpakket->producten()->sync($syncData);
        } else {
            $voedselpakket->producten()->detach();
        }

        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket bijgewerkt.');
    }

    public function destroy(Voedselpakket $voedselpakket)
    {
        $voedselpakket->delete();
        return redirect()->route('voedselpakketten.index')->with('success', 'Voedselpakket verwijderd.');
    }
}






