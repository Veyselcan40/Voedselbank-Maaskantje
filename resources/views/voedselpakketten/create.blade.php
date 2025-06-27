@extends('layouts.app')

@section('content')
    <h1>Nieuw voedselpakket aanmaken</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('voedselpakketten.store') }}">
        @csrf
        <label for="klant_id">Klant:</label>
        <select name="klant_id" id="klant_id" required>
            <option value="">Selecteer klant</option>
            @foreach($klanten as $klant)
                <option value="{{ $klant->id }}">{{ $klant->naam }}</option>
            @endforeach
        </select><br>

        <label for="datum_samenstelling">Datum Samenstelling:</label>
        <input type="date" name="datum_samenstelling" id="datum_samenstelling" required><br>

        <h3>Producten</h3>
        <div id="producten-container">
            <div class="product-row">
                <select name="producten[0][product_id]" required>
                    <option value="">Selecteer product</option>
                    @foreach($producten as $product)
                        <option value="{{ $product->id }}">{{ $product->productnaam }} ({{ $product->aantal_in_voorraad }})</option>
                    @endforeach
                </select>
                <input type="number" name="producten[0][aantal]" min="1" value="1" required>
                <button type="button
