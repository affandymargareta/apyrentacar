<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'productname_id',
        'seller_id',
	];

    public function seller()
    {
        return $this->belongsTo(Seller::class,'seller_id');
    }
    public function productName()
    {
        return $this->belongsTo(ProductName::class,'productname_id');
    }
}
