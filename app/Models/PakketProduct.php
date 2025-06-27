<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakketproduct extends Model
{
    use HasFactory;

    protected $table = 'pakketproduct';
    protected $fillable = ['voedselpakket_id', 'product_id', 'aantal'];

    public function voedselpakket()
    {
        return $this->belongsTo(Voedselpakket::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
