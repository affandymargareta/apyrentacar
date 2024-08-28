<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanpaSopirCart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tanpasopir()
    {
        return $this->belongsTo(TanpaSopir::class, 'product_id');
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
