<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function initPaymentGateway()
	{
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
	}
}
