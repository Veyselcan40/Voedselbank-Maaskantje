<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voedselpakket extends Model
{
    protected $table = 'voedselpakket';  // expliciete tabelnaam

    protected $fillable = [
        'klant_id',
        'datum_samenstelling',
        'datum_uitgifte',
    ];

    // Relatie met Klant
    public function klant()
    {
        return $this->belongsTo(Klant::class);
    }
}
