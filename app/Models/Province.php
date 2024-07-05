<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $table = "provinces";

    public function products()
    {
        return $this->hasMany(Product::class, 'wilayah');
    }

    public function provincePrice()
    {
        return $this->hasOne(CityPrice::class, 'province_id');
    }
}
