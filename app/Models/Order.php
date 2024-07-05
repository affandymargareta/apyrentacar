<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    use HasFactory;
    protected $guarded = [];
	// protected $table = 'orders';
    // protected $fillable = [
	// 	'user_id',
	// 	'invoice',
    //     'order_date',
	// 	'payment_due',
	// 	'payment_status',
	// 	'payment_token',
	// 	'payment_url',
	// 	'wilayah',
	// 	'jemput_id',
	// 	'lokasi_jemput',
	// 	'kembali_id',
	// 	'lokasi_kembali',
	// 	'mulai',
	// 	'durasi',
	// 	'jam_mulai',
	// 	'jam_akhir',
	// 	'seller_id',
	// 	'supir_telpon',
	// 	'supir_name',
	// 	'plat_nomer',
    //     'product_id',
	// 	'customer_name',
	// 	'customer_telpon',
	// 	'customer_email',
	// 	'price',
	// ];

	// protected $appends = ['customer_full_name'];

	public const CREATED = 'created';
	public const CONFIRMED = 'confirmed';
	public const PROCESSED = 'diperoses';
	public const COMPLETED = 'completed';
	public const CANCELLED = 'cancelled';

	public const ORDERCODE = 'INV';

	public const PAID = 'paid';
	public const UNPAID = 'unpaid';

	public const STATUSES = [
		self::CREATED => 'Created',
		self::CONFIRMED => 'Confirmed',
		self::PROCESSED => 'Diperoses',
		self::COMPLETED => 'Completed',
		self::CANCELLED => 'Cancelled',
	];
	/**
	 * Define relationship with the OrderItem
	 *
	 * @return void
	 */
	
    /**
	 * Define relationship with the User
	 *
	 * @return void
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Generate order code
	 *
	 * @return string
	 */
	public static function generateCode()
	{
		$dateCode = self::ORDERCODE . '/' . date('Ymd') . '/' . date('m'). '/' .date('d'). '/';

		$lastOrder = self::select([DB::raw('MAX(orders.invoice) AS last_code')])
			->where('invoice', 'like', $dateCode . '%')
			->first();

		$lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
		
		$orderCode = $dateCode . '00001';
		if ($lastOrderCode) {
			$lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
			$nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
			
			$orderCode = $dateCode . $nextOrderNumber;
		}

		// if (self::_isOrderCodeExists($orderCode)) {
		// 	return generateOrderCode();
		// }

		return $orderCode;
	}

	/**
	 * Check if the generated order code is exists
	 *
	 * @param string $orderCode order code
	 *
	 * @return void
	 */
	// private static function _isOrderCodeExists($orderCode)
	// {
	// 	return Order::where('invoice', '=', $orderCode)->exists();
	// }

	/**
	 * Check order is paid or not
	 *
	 * @return boolean
	 */
	public function isPaid()
	{
		return $this->payment_status == self::PAID;
	}

	public function isUnPaid()
	{
		return $this->payment_status == self::UNPAID;
	}

	/**
	 * Check order is created
	 *
	 * @return boolean
	 */
	public function isCreated()
	{
		return $this->status == self::CREATED;
	}

	/**
	 * Check order is Diperoses
	 *
	 * @return boolean
	 */
	public function isProcessed()
	{
		return $this->status == self::PROCESSED;
	}

	/**
	 * Check order is confirmed
	 *
	 * @return boolean
	 */
	public function isConfirmed()
	{
		return $this->status == self::CONFIRMED;
	}

	/**
	 * Check order is completed
	 *
	 * @return boolean
	 */
	public function isCompleted()
	{
		return $this->status == self::COMPLETED;
	}

	/**
	 * Check order is cancelled
	 *
	 * @return boolean
	 */
	public function isCancelled()
	{
		return $this->status == self::CANCELLED;
	}

	public function getStatusLabelAttribute()
    {
        //ADAPUN VALUENYA AKAN MENCETAK HTML BERDASARKAN VALUE DARI FIELD STATUS
        if ($this->payment_status == self::PAID) {
			return '<span class="badge badge-success">Aktif</span>';
        }
		return '<span class="badge badge-secondary">Tidak Aktif</span>';
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'product_id');
    }

	public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
