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

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->streepjescode)) {
                do {
                    $barcode = str_pad(strval(random_int(0, 9999999999999)), 13, '0', STR_PAD_LEFT);
                } while (self::where('streepjescode', $barcode)->exists());
                $product->streepjescode = $barcode;
            }
        });
    }

    // Relatie met voedselpakketten via pivot-tabel
    public function voedselpakketten()
    {
        return $this->belongsToMany(Voedselpakket::class, 'voedselpakket_product', 'product_id', 'voedselpakket_id')
            ->withPivot('aantal');
    }
}
