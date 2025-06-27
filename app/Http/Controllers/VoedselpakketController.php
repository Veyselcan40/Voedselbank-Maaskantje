<?php

namespace App\Http\Controllers;

use App\Models\Voedselpakket;
use App\Models\Klant;
use App\Models\Product;
use App\Models\Pakketproduct;
use Illuminate\Http\Request;

class VoedselpakketController extends Controller
{
    public function index()
    {
        $voedselpakketten = Voedselpakket::with('klant')->paginate(10);
        return view('voedselpakketten.index', compact('voedselpakketten'));
    }

    public function create()
    {
        $klanten = Klant::all();
        $producten = Product::all();
        return view('voedselpakketten.create', compact('klanten', 'producten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klant_id' => 'required|exists:klanten,id',
            'datum_samenstelling' => 'required|date',
            'producten' => 'required|array',
            'producten.*.product_id' => 'required|exists:producten,id',
            'producten.*.aantal' => 'required|integer|min:1',
        ]);

        // Maak voedselpakket aan
        $voedselpakket = Voedselpakket::create([
            'klant_id' => $request->klant_id,
            'datum_samenstelling' => $request->datum_samenstelling,
            'datum_uitgifte' => null,
        ]);

        // Voeg producten toe aan pakket
        foreach ($request->producten as $productData) {
            Pakketproduct::create([
                'voedselpakket_id' => $voedselpakket->id,
                'product_id' => $productData['product_id'],
                'aantal' => $productData['aantal'],
            ]);
        }

        return redirect()->route('voedselpakketten.index')
            ->with('success', 'Voedselpakket succesvol aangemaakt.');
    }

    // TODO: show, edit, update, destroy methods nog toevoegen
}
