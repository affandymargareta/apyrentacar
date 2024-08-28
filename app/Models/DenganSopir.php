<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenganSopir extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'seller_id',
        'jenis',
        'status',
        'wilayah',
        'bagasi',
        'kursi',
        'stock',
        'price',
        'status',
	];

    public function getStatusLabelAttribute()
    {
        //ADAPUN VALUENYA AKAN MENCETAK HTML BERDASARKAN VALUE DARI FIELD STATUS
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Tidak Aktif</span>';
        }
        return '<span class="badge badge-success">Aktif</span>';
    }

    public function province()
    {
        return $this->belongsTo(Province::class,'wilayah');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function productName()
    {
        return $this->belongsTo(ProductName::class,'name');
    }

    public function productImages()
    {
        return $this->belongsTo(ProductImage::class,'name');
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class, 'name');
    }

}
