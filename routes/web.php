<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\DenganSopirCartController;
use App\Http\Controllers\FrontEnd\TanpaSopirCartController;
use App\Http\Controllers\FrontEnd\TanpaSopirOrderController;
use App\Http\Controllers\FrontEnd\DenganSopirOrderController;
use App\Http\Controllers\FrontEnd\PaymentController;

use App\Http\Controllers\Admin\AdminDashboardController;
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


use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerDenganSopirController;
use App\Http\Controllers\Seller\SellerTanpaSopirController;
use App\Http\Controllers\Seller\SellerOrderV1Controller;
use App\Http\Controllers\Seller\SellerOrderV2Controller;


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
    
    
    Route::post('userinvoice1', [HomeController::class, 'UserInvoice1'])->name('userinvoice1');
    Route::post('userinvoice2', [HomeController::class, 'UserInvoice2'])->name('userinvoice2');
    Route::post('userinvoice3', [HomeController::class, 'UserInvoice3'])->name('userinvoice3');
    Route::post('userinvoice4', [HomeController::class, 'UserInvoice4'])->name('userinvoice4');




    Route::get('/users/invoice/detail/{id}', [HomeController::class, 'InvoiceDetail'])->name('users.invoice');
    
    /////
    Route::get('searchv1', [HomeController::class, 'CategorySearch1'])->name('searching1');
    Route::get('searchv2', [HomeController::class, 'CategorySearch2'])->name('searching2');

    Route::get('/cars/v1/detail/{id}', [HomeController::class, 'CarDetail1'])->name('cardetail1');
    Route::get('/cars/v2/detail/{id}', [HomeController::class, 'CarDetail2'])->name('cardetail2');

    Route::post('/cartstore1', [TanpaSopirCartController::class, 'store'])->name('cartstore1');
    Route::post('/cartstore2', [DenganSopirCartController::class, 'store'])->name('cartstore2');
    Route::put('/cartupdate1/{id}', [TanpaSopirCartController::class, 'update'])->name('cartupdate1');
    Route::put('/cartupdate2/{id}', [DenganSopirCartController::class, 'update'])->name('cartupdate2');
    Route::get('/booking1/{id}', [HomeController::class, 'Booking1'])->name('booking1');
    Route::get('/booking2/{id}', [HomeController::class, 'Booking2'])->name('booking2');

    Route::post('/orders1', [TanpaSopirOrderController::class, 'store'])->name('orders1.store');
    Route::post('/orders2', [DenganSopirOrderController::class, 'store'])->name('orders2.store');

    
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
    Route::resource('dengansopirm', SellerDenganSopirController::class);
    Route::resource('tanpasopirm', SellerTanpaSopirController::class);

    Route::get('/mtanpasopir', [SellerOrderV1Controller::class, 'mtanpasopir'])->name('mtanpasopir');
    Route::put('/mtanpasopirpdate/{id}', [SellerOrderV1Controller::class, 'update'])->name('mtanpasopirpdate.update');
    Route::get('/mtanpasopir/{id}', [SellerOrderV1Controller::class, 'edit'])->name('mtanpasopir.edit');
    Route::get('/mtanpasopir/detail/{id}', [SellerOrderV1Controller::class, 'show'])->name('mtanpasopir.show');


    Route::get('/mdengansopir', [SellerOrderV2Controller::class, 'mdengansopir'])->name('mdengansopir');
    Route::put('/mdengansopirpdate/{id}', [SellerOrderV2Controller::class, 'update'])->name('mdengansopirupdate.update');
    Route::get('/mdengansopir/{id}', [SellerOrderV2Controller::class, 'edit'])->name('mdengansopir.edit');
    Route::get('/mdengansopir/detail/{id}', [SellerOrderV2Controller::class, 'show'])->name('mdengansopir.show');


    
    });
    
    
    
    /*
    |--------------------------------------------------------------------------
    |                            Seller Area
    |--------------------------------------------------------------------------
    */
