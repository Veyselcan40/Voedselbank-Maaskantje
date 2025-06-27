<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'producten';

    protected $fillable = [
        'streepjescode',
        'naam',
        'categorie',
        'aantal',
    ];

    // Relatie met voedselpakketten via pivot-tabel
    public function voedselpakketten()
    {
        return $this->belongsToMany(Voedselpakket::class, 'voedselpakket_product', 'product_id', 'voedselpakket_id')
            ->withPivot('aantal');
    }
}
