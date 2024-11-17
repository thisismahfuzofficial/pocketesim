<?php

use App\Console\Commands\EsimApiSync;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Mail\NewOrderInvoiceMail;
use App\Mail\OrderInvoice;
use App\Models\Country;
use App\Models\Order;
use App\Models\Plan;
use App\Services\Api\Esim\EsimAccessApi;
use App\Services\Api\Esim\EsimApi;
use App\Services\Api\Esim\EsimGoApi;
use App\Services\Api\Esim\EsimSmApi;
use App\Services\Purchase\BalanceCheckService;
use App\Services\Sync\CountryPlanSync;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\Page;

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
//     $countries = Country::topCountries()->get();

//     return view('home', compact('countries'));
// })->name('home');

Auth::routes();



Route::controller(HomeController::class)->group(function () {

    Route::get('/', 'index')->name('home');
    Route::get('/thankyou', 'thankyou')->name('thankyou');
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/profile', 'Profile')->name('show.profile');
        Route::post('/profile/update', 'UpdateName')->name('update.name');
        Route::post('/profile/password',  'Update')->name('update.pass');
        Route::get('/orders', 'orders')->name('show.orders');
        Route::get('/order/{id}', 'singleOrder')->name('single.order');
    });
});
Route::controller(PagesController::class)->group(function () {
    Route::get('/destinations', 'Destination')->name('show.destinations');
    Route::get('/partner-with-us', 'PartnerUs')->name('show.partner.us');
    Route::get('/about-us', 'AboutUs')->name('show.about.us');
    Route::get('/destinations/search', 'search')->name('search.destinations');
    Route::get('/search/suggestions', 'suggestions')->name('search.suggestions');
});
Route::controller(ProductController::class)->group(function () {

    Route::get('/destinations/{country:code}', 'products')->name('show.products');
});
Route::controller(CheckOutController::class)->group(function () {
    Route::post('/checkout', 'checkout')->name('checkout');
    Route::get('/check-out', 'checkoutIndex')->name('show.checkout');
    Route::post('/complete-checkout', 'checkoutComplete')->name('complete.checkout');
});



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('countries/sync/{param}', function ($param) {
        try {

            if ($param == 'all') {
                $countries =  Country::all();

                foreach ($countries as $country) {
                    try {
                        (new CountryPlanSync($country))->sync();
                    } catch (Exception $e) {
                        continue;
                    }
                }
            } else {
                $country = Country::where('code', $param)->first();
                try {

                    (new CountryPlanSync($country))->sync();
                } catch (Exception $e) {
                    throw $e;
                }
            }
            return redirect()->back()->with([
                'message'    => "Sync successfull",
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    })->name('voyager.countries.sync');
});

Route::get('/test', function (Request $request) {
    $order = Order::latest()->first();
    return new NewOrderInvoiceMail($order);
});

Route::get('check-balance', function (Request $request) {

    $balance = null;
    if ($request->filled('iccid')) {
        $order = Order::whereJsonContains('iccid', $request->iccid)->first();
        if ($order) {
            $balance = BalanceCheckService::balance(order: $order, iccid: $request->iccid);
        } else {
            $balance = [
                'status' => 'false',
                'message' => 'no order found'
            ];
        }
    }

    return view('pages.balance', compact('balance'));
});
Route::get('{page:slug}', function (Page $page) {

    return view('pages.page', compact('page'));
})->name('page');
