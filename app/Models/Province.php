<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $table = "provinces";

    public function dengansopirs()
    {
        return $this->hasMany(DenganSopir::class, 'wilayah');
    }

    public function provincePrice()
    {
        return $this->hasOne(CityPrice::class, 'province_id');
    }

    public function city()
    {
        return $this->hasMany(City::class);
    }
}
