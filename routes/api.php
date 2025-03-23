<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\DeliveryBoyController;
use App\Http\Controllers\Api\SponsoredBannerProductController;
use App\Http\Controllers\Api\PromotionalBannerProductController;
use App\Http\Controllers\Api\OfferBannerProductController;

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
    // return $request->user();
});
Route::post("home", [HomeController::class, 'home']);
Route::post("seeAll", [HomeController::class, 'seeAll']);

Route::post("categoryByProducts", [CategoryController::class, 'categoryByProducts']);
Route::get("seeAllCategory", [CategoryController::class, 'seeAllCategory']);
Route::post("subCategoryByProducts", [CategoryController::class, 'subCategoryByProducts']);

Route::post("products", [ProductController::class, 'products']);
Route::post("search", [ProductController::class, 'search']);
Route::post("recentSearch", [ProductController::class, 'recentSearch']);
Route::get("getRecentSearches", [ProductController::class, 'getRecentSearches']);
Route::get("clearRecentSearches", [ProductController::class, 'clearRecentSearches']);

Route::post("sponsoredBannerByProducts", [SponsoredBannerProductController::class, 'sponsoredBannerByProducts']);

Route::post("promotionalBannerByProducts", [PromotionalBannerProductController::class, 'promotionalBannerByProducts']);

Route::post("offerBannerByProducts", [OfferBannerProductController::class, 'offerBannerByProducts']);

Route::post("setting", [SettingController::class, 'setting']);



Route::middleware('loginToken')->group(function () {

    Route::post("profile", [CustomerController::class, 'profile']);
    Route::post("updateProfile", [CustomerController::class, 'updateProfile']);
    Route::post("addToCart", [CartController::class, 'addToCart']);
    Route::post("removeCart", [CartController::class, 'removeCart']);
    Route::post("cartMinus", [CartController::class, 'cartMinus']);
    Route::post("cart", [CartController::class, 'cart']);
    Route::post("cartQuantity", [CartController::class, 'cartQuantity']);
    Route::post("order", [OrderController::class, 'order']);
    Route::post("verify-order", [OrderController::class, 'verifyOrder']);
    Route::post("myOrder", [OrderController::class, 'myOrder']);
    Route::post("verifyOtpForDelivery", [OrderController::class, 'verifyOtpForDelivery']);
    Route::post("orderByProducts", [OrderController::class, 'orderByProducts']);
    Route::post("cancelOrder", [OrderController::class, 'cancelOrder']);
    Route::post("couponCode", [OrderController::class, 'couponCode']);
    Route::post("addressStore", [AddressController::class, 'addressStore']);
    Route::post("removeAddress", [AddressController::class, 'removeAddress']);
    Route::post("addresses", [AddressController::class, 'addresses']);

    // delivery boy api
    Route::post("deliveryboy/profile", [DeliveryBoyController::class, 'profile']);
});


    Route::post("register", [AuthController::class, 'register']);
    Route::post("sendOtp", [AuthController::class, 'sendOtp']);
    Route::post("verifyOtp", [AuthController::class, 'verify_otp']);
    Route::post("login", [AuthController::class, 'login']);
    Route::post("forgetPassword", [AuthController::class, 'forgetPassword']);




    // delivery boy api
    Route::post("deliveryboy/login", [AuthController::class, 'deliveryBoyLogin']);


Route::middleware('deliveryBoyLoginToken')->group(function () {
    Route::post("deliveryboy/profile", [DeliveryBoyController::class, 'profile']);
    Route::post("deliveryboy/update-profile", [DeliveryBoyController::class, 'updateProfile']);
    Route::post("deliveryboy/pendingOrders", [DeliveryBoyController::class, 'pendingOrders']);
    Route::post("deliveryboy/deliveredOrders", [DeliveryBoyController::class, 'deliveredOrders']);
    Route::post("deliveryboy/changeOrderStatus", [DeliveryBoyController::class, 'changeOrderStatus']);
    Route::post("deliveryboy/paymentHistory", [DeliveryBoyController::class, 'paymentHistory']);
    Route::post("sendOtpDelivery", [OrderController::class, 'sendOtpDelivery']);
    Route::post("deliveryboy/setting", [DeliveryBoyController::class, 'setting']);
});

Route::post('/payment-callback', [OrderController::class, 'callback']);
