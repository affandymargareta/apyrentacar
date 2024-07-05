<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CityPriceController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductNameController;
use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\Admin\ProductCarController;
use App\Http\Controllers\Admin\SellerPaymentController;


use App\Http\Controllers\FrontEnd\OrderController;
use App\Http\Controllers\FrontEnd\PaymentController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;


use App\Http\Controllers\Auth\UserProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/cartstore', [CartController::class, 'store'])->name('cartstore');
    Route::get('/booking/{id}', [HomeController::class, 'Booking'])->name('booking');
    Route::put('/cartupdate/{id}', [CartController::class, 'update'])->name('cartupdate');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/user/account/{id}', [UserProfileController::class, 'UserAccount'])->name('user.account');
    Route::put('/userupdate/{id}', [UserProfileController::class, 'update'])->name('userupdate');
    Route::get('/user/dashboard', [HomeController::class, 'UserCar'])->name('user.dashboard');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
|                            Admin Area
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->group(function () {

    Route::get('admin/dashboard', [AdminDashboardController::class, 'Dashboard'])->name('admin.dashboard');
    Route::get('member', [AdminDashboardController::class, 'Seller'])->name('member');
    
    Route::get('customers', [AdminDashboardController::class, 'User'])->name('customers');
    
    
    Route::resource('product', ProductController::class);
    Route::resource('banner', BannerController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('city', CityController::class);
    Route::resource('province', ProvinceController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('cityprice', CityPriceController::class);
    Route::resource('aorder', AdminOrderController::class);
    Route::resource('addon', AddOnController::class);
    Route::put('/sellerupdate/{id}', [AdminDashboardController::class, 'Sellerupdate'])->name('sellerupdate');
    Route::get('/suspend/{id}', [AdminDashboardController::class, 'Selleredit'])->name('suspend');
    
    });
    
    Route::resource('productimage', ProductImageController::class);
    Route::resource('productname', ProductNameController::class);
    Route::resource('productcar', ProductCarController::class);
    Route::resource('sellerpayment', SellerPaymentController::class);
    
    
    /*
    |--------------------------------------------------------------------------
    |                            Admin Area
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    |                            FrontEnd Area
    |--------------------------------------------------------------------------
    */
    
    
    Route::post('userinvoice', [HomeController::class, 'UserInvoice'])->name('userinvoice');
    
    Route::get('/users/invoice/detail/{id}', [HomeController::class, 'InvoiceDetail'])->name('users.invoice');
    
    /////
    Route::get('search', [HomeController::class, 'CategorySearch'])->name('searching');
    Route::get('/cars/detail/{id}', [HomeController::class, 'CarDetail'])->name('cardetail');
    
    
    
    
    
    /*
    |--------------------------------------------------------------------------
    |                            FrontEnd Area
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    |                            FrontEnd Area
    |--------------------------------------------------------------------------
    */
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/companys/profile', [HomeController::class, 'Companys'])->name('companys.profile');
    Route::get('/article', [HomeController::class, 'Article'])->name('article');
    Route::get('/services', [HomeController::class, 'Services'])->name('services');
    Route::get('/contacts/company', [HomeController::class, 'Contacts'])->name('contacts.company');
    Route::get('/testimonis/company', [HomeController::class, 'Testimonis'])->name('testimonis.company');
    Route::put('/carupdate/{id}', [HomeController::class, 'CarUpdate'])->name('carupdate.CarUpdate');
    Route::get('/checkout', [HomeController::class, 'Checkout'])->name('checkout');
    
    Route::get('/orders/{invoice}', [HomeController::class, 'index'])->name('orders.index');
    
    
    /*
    |--------------------------------------------------------------------------
    |                            FrontEnd Area
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    |                            FrontEnd payments
    |--------------------------------------------------------------------------
    */
    Route::post('payments/notification', [PaymentController::class, 'notification']);
    Route::get('payments/completed', [PaymentController::class, 'completed']);
    Route::get('payments/failed', [PaymentController::class, 'failed']);
    Route::get('payments/unfinish', [PaymentController::class, 'unfinish']);
    /*
    |--------------------------------------------------------------------------
    |                            FrontEnd payments
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    |                            Seller Area
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:seller')->group(function () {
    
    Route::get('/mdashboard', [SellerDashboardController::class, 'Dashboard'])->name('mdashboard');
    Route::resource('productm', SellerProductController::class);
    
    Route::get('/morder', [SellerOrderController::class, 'index'])->name('morder.index');
    Route::put('/morderpdate/{id}', [SellerOrderController::class, 'update'])->name('morderpdate.update');
    Route::get('/morder/{id}', [SellerOrderController::class, 'edit'])->name('morder.edit');
    Route::get('/morder/detail/{id}', [SellerOrderController::class, 'show'])->name('morder.show');
    
    });
    
    
    
    /*
    |--------------------------------------------------------------------------
    |                            Seller Area
    |--------------------------------------------------------------------------
    */
