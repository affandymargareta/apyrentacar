<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'province_id',
        'zona',
		'price',
	];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
    public function productName()
    {
        return $this->belongsTo(ProductName::class,'product_id');
    }
}
