<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    use HasFactory;


    protected $table = 'klanten';

    protected $fillable = [
        'naam',
        'adres',
        'telefoon',
        'email',

    protected $table = 'klanten'; // <-- fix hier

    protected $fillable = [
        'naam',
        'telefoon',
        'email',
        'postcode',
        'aantal_volwassenen',
        'aantal_kinderen',
        'aantal_babys'

    ];
}
