<?php

use App\Models\Country;
use App\Models\Order;
use App\Services\Purchase\BalanceCheckService;
use App\Services\Purchase\BlanceCheckService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stripe\Service\BalanceService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/countries', function (Request $request) {

    $query = $request->input('q');
    if ($request->filled('q')) {

        $countries = Country::where('name', 'LIKE', "{$query}%")->where('status', 'active')->limit(10)->get()->map(fn ($country) => [
            'link' => route('show.products', $country),
            'name' => $country->name,
            'flag' => Voyager::image($country->flag)
        ]);
    } else {
        $countries = [];
    }
    return response()->json($countries);
})->name('api.countries.search');

Route::get('/check-balance/{iccid}', function ($iccid) {
    $order = Order::whereJsonContains('iccid', $iccid)->first();
    return response()->json(BalanceCheckService::balance(order: $order, iccid: $iccid));
});
