<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\HomeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('city1', [HomeController::class, 'getCitys1'])->name('city1');

Route::get('city2', [HomeController::class, 'getCitys2'])->name('city2');


Route::get('cityprice1', [HomeController::class, 'getCityPrice1'])->name('cityprice1');
Route::get('cityprice2', [HomeController::class, 'getCityPrice2'])->name('cityprice2');