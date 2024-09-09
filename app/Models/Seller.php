<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'phone',
    //     'address',
    //     'tanggal',
    //     'city',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class,'city');
    }
    public function tanpaSopirs()
    {
        return $this->hasMany(TanpaSopir::class, 'seller_id');
    }
    public function denganSopirs()
    {
        return $this->hasMany(DenganSopir::class, 'seller_id');
    }

}
