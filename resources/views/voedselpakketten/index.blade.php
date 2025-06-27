@extends('layouts.app')

@section('content')
    <h1>Voedselpakketten</h1>
    <a href="{{ route('voedselpakketten.create') }}">Nieuw voedselpakket</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Klant</th>
                <th>Datum Samenstelling</th>
                <th>Datum Uitgifte</th>
            </tr>
        </thead>
        <tbody>
            @foreach($voedselpakketten as $pakket)
                <tr>
                    <td>{{ $pakket->id }}</td>
                    <td>{{ $pakket->klant->naam }}</td>
                    <td>{{ $pakket->datum_samenstelling }}</td>
                    <td>{{ $pakket->datum_uitgifte ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $voedselpakketten->links() }}
@endsection
