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
        'nummer',
    ];

    // Relatie met Klant
    public function klant()
    {
        return $this->belongsTo(Klant::class);
    }

    // Relatie met producten (voorraad) via pivot-tabel
    public function producten()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'voedselpakket_product', 'voedselpakket_id', 'product_id')
            ->withPivot('aantal');
    }
}
