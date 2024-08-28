<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenganSopirCart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dengansopir()
    {
        return $this->belongsTo(DenganSopir::class, 'product_id');
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
