<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'image',
	];

    public function productName()
    {
        return $this->belongsTo(ProductName::class,'product_id','id');
    }

    public function tanpaSopir()
    {
        return $this->belongsTo(TanpaSopir::class, 'product_id', 'name');
    }    
    public function denganSopir()
    {
        return $this->belongsTo(DenganSopir::class, 'product_id', 'name');
    }  
}
