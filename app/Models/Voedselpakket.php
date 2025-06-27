<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voedselpakket extends Model
{
    use HasFactory;

    protected $table = 'voedselpakket';
    protected $fillable = ['klant_id', 'datum_samenstelling', 'datum_uitgifte'];

    public function klant()
    {
        return $this->belongsTo(Klant::class);
    }

    public function pakketproducten()
    {
        return $this->hasMany(Pakketproduct::class);
    }
}
