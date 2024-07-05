<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'addon_price',
	];

    public function productName()
    {
        return $this->belongsTo(ProductName::class,'product_id');
    }
}
