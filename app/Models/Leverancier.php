<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'leveranciers'; // <-- aangepast naar meervoud
    protected $primaryKey = 'id';      // <-- standaard Laravel conventie
    public $timestamps = true;         // timestamps zijn aanwezig in migratie

    protected $fillable = [
        'Bedrijfsnaam',
        'Adres',
        'Contactpersoon',
        'Email',
        'Telefoon',
        'EerstvolgendeLevering',
        'Leverancierstype'
    ];
}

