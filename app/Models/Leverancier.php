<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'Leverancier';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Bedrijfsnaam',
        'Adres',
        'Contactpersoon',
        'Email',
        'Telefoon',
        'EerstvolgendeLevering'
    ];
}
