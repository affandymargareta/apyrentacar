<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TanpaSopir extends Model
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

    // Define the inverse relationship
    public function productName()
    {
        return $this->belongsTo(ProductName::class, 'name', 'id');
    }

    // Method to get product names with the lowest price
    public static function getProductNamesWithLowestPrice()
    {
        return self::select('name', DB::raw('MIN(price) as lowest_price'))
            ->groupBy('name')
            ->get();
    }

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

    public function productImages()
    {
        return $this->belongsTo(ProductImage::class, 'name', 'product_id');
    }
    
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
