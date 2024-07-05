<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'seller_id',
        'image',
        'price',
        'date',
	];

    public function seller()
    {
        return $this->belongsTo(Seller::class,'seller_id');
    }
}
