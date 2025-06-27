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
        $klanten = Klant::all();
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

        return redirect()->route('voedselpakket.index')->with('success', 'Voedselpakket toegevoegd.');
    }

    public function show(Voedselpakket $voedselpakket)
    {
        return view('voedselpakket.show', compact('voedselpakket'));
    }

    public function edit(Voedselpakket $voedselpakket)
    {
        $klanten = Klant::all();
        return view('voedselpakket.edit', compact('voedselpakket', 'klanten'));
    }

    public function update(Request $request, Voedselpakket $voedselpakket)
    {
        $request->validate([
            'klant_id' => 'required|exists:klanten,id',
            'datum_samenstelling' => 'required|date',
            'datum_uitgifte' => 'nullable|date',
        ]);

        $voedselpakket->update($request->all());

        return redirect()->route('voedselpakket.index')->with('success', 'Voedselpakket bijgewerkt.');
    }

    public function destroy(Voedselpakket $voedselpakket)
    {
        $voedselpakket->delete();
        return redirect()->route('voedselpakket.index')->with('success', 'Voedselpakket verwijderd.');
    }
}
