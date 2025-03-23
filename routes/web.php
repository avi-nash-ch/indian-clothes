<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('front.index');
// Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin.dashboard');

    // order
    Route::get('/admin/order', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('order.index');
    Route::get('/admin/order/{id}/view', [App\Http\Controllers\Admin\OrderController::class, 'view'])->name('order.view');
    Route::get('/admin/order/{id}/print', [App\Http\Controllers\Admin\OrderController::class, 'print'])->name('order.print');
    Route::get('/admin/update-order-status', [App\Http\Controllers\Admin\OrderController::class, 'updateOrderStatus'])->name('order.updateOrderStatus');
    Route::get('/admin/update-order-payment-status', [App\Http\Controllers\Admin\OrderController::class, 'updateOrderPaymentStatus'])->name('order.updateOrderStatus');
    Route::get('/admin/order/{id}/delete', [App\Http\Controllers\Admin\OrderController::class, 'delete'])->name('order.delete');
    Route::post('/admin/order/refund', [App\Http\Controllers\Admin\OrderController::class, 'refund'])->name('order.refund');
    Route::post('/admin/order/comment', [App\Http\Controllers\Admin\OrderController::class, 'storeComment'])->name('order.comment');

    // user
    Route::get('/admin/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
    Route::get('/admin/user/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.edit');
    Route::post('/admin/user/{id}/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('user.update');
    Route::get('/admin/user/{id}/view', [App\Http\Controllers\Admin\UserController::class, 'view'])->name('user.view');
    Route::get('/admin/user/{id}/delete', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('user.delete');
    Route::get('/admin/user/{id}/block', [App\Http\Controllers\Admin\UserController::class, 'block'])->name('user.block');
    Route::get('/admin/user/{id}/addressList', [App\Http\Controllers\Admin\UserController::class, 'addressList'])->name('user.addressList');

    // promotional banner
    Route::get('/admin/promotionalBanner', [App\Http\Controllers\Admin\PromotionalBannerController::class, 'index'])->name('promotionalBanner.index');
    Route::get('/admin/promotionalBanner/create', [App\Http\Controllers\Admin\PromotionalBannerController::class, 'create'])->name('promotionalBanner.create');
    Route::post('/admin/promotionalBanner/store', [App\Http\Controllers\Admin\PromotionalBannerController::class, 'store'])->name('promotionalBanner.store');
    Route::get('/admin/promotionalBanner/{id}/edit', [App\Http\Controllers\Admin\PromotionalBannerController::class, 'edit'])->name('promotionalBanner.edit');
    Route::post('/admin/promotionalBanner/{id}/update', [App\Http\Controllers\Admin\PromotionalBannerController::class, 'update'])->name('promotionalBanner.update');
    Route::get('/admin/promotionalBanner/{id}/delete', [App\Http\Controllers\Admin\PromotionalBannerController::class, 'delete'])->name('promotionalBanner.delete');

    // offer banner
    Route::get('/admin/offerBanner', [App\Http\Controllers\Admin\OfferBannerController::class, 'index'])->name('offerBanner.index');
    Route::get('/admin/offerBanner/create', [App\Http\Controllers\Admin\OfferBannerController::class, 'create'])->name('offerBanner.create');
    Route::post('/admin/offerBanner/store', [App\Http\Controllers\Admin\OfferBannerController::class, 'store'])->name('offerBanner.store');
    Route::get('/admin/offerBanner/{id}/edit', [App\Http\Controllers\Admin\OfferBannerController::class, 'edit'])->name('offerBanner.edit');
    Route::post('/admin/offerBanner/{id}/update', [App\Http\Controllers\Admin\OfferBannerController::class, 'update'])->name('offerBanner.update');
    Route::get('/admin/offerBanner/{id}/delete', [App\Http\Controllers\Admin\OfferBannerController::class, 'delete'])->name('offerBanner.delete');

    // category
    Route::get('/admin/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.index');
    Route::get('/admin/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create');
    Route::post('/admin/category/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.store');
    Route::get('/admin/category/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/admin/category/{id}/update', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
    Route::get('/admin/category/{id}/delete', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('category.delete');

    // subCategory
    Route::get('/admin/subCategory', [App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->name('subCategory.index');
    Route::get('/admin/subCategory/create', [App\Http\Controllers\Admin\SubCategoryController::class, 'create'])->name('subCategory.create');
    Route::post('/admin/subCategory/store', [App\Http\Controllers\Admin\SubCategoryController::class, 'store'])->name('subCategory.store');
    Route::get('/admin/subCategory/{id}/edit', [App\Http\Controllers\Admin\SubCategoryController::class, 'edit'])->name('subCategory.edit');
    Route::post('/admin/subCategory/{id}/update', [App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->name('subCategory.update');
    Route::get('/admin/subCategory/{id}/delete', [App\Http\Controllers\Admin\SubCategoryController::class, 'delete'])->name('subCategory.delete');

    // product
    Route::get('/admin/product', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('product.index');
    Route::get('/admin/product/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('product.create');
    Route::post('/admin/product/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('product.store');
    Route::get('/admin/product/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('product.edit');
    Route::post('/admin/product/{id}/update', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('product.update');
    Route::get('/admin/product/{id}/delete', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('product.delete');

    
    Route::delete('/product/{product}/remove-image', [App\Http\Controllers\Admin\ProductController::class, 'removeImage'])->name('product.removeImage');

    // bestSeller
    Route::get('/admin/bestSeller', [App\Http\Controllers\Admin\BestSellerController::class, 'index'])->name('bestSeller.index');
    Route::get('/admin/bestSeller/create', [App\Http\Controllers\Admin\BestSellerController::class, 'create'])->name('bestSeller.create');
    Route::post('/admin/bestSeller/store', [App\Http\Controllers\Admin\BestSellerController::class, 'store'])->name('bestSeller.store');
    Route::get('/admin/bestSeller/{id}/edit', [App\Http\Controllers\Admin\BestSellerController::class, 'edit'])->name('bestSeller.edit');
    Route::post('/admin/bestSeller/{id}/update', [App\Http\Controllers\Admin\BestSellerController::class, 'update'])->name('bestSeller.update');
    Route::get('/admin/bestSeller/{id}/delete', [App\Http\Controllers\Admin\BestSellerController::class, 'delete'])->name('bestSeller.delete');

    // partyTime
    Route::get('/admin/partyTime', [App\Http\Controllers\Admin\PartyTimeController::class, 'index'])->name('partyTime.index');
    Route::get('/admin/partyTime/create', [App\Http\Controllers\Admin\PartyTimeController::class, 'create'])->name('partyTime.create');
    Route::post('/admin/partyTime/store', [App\Http\Controllers\Admin\PartyTimeController::class, 'store'])->name('partyTime.store');
    Route::get('/admin/partyTime/{id}/edit', [App\Http\Controllers\Admin\PartyTimeController::class, 'edit'])->name('partyTime.edit');
    Route::post('/admin/partyTime/{id}/update', [App\Http\Controllers\Admin\PartyTimeController::class, 'update'])->name('partyTime.update');
    Route::get('/admin/partyTime/{id}/delete', [App\Http\Controllers\Admin\PartyTimeController::class, 'delete'])->name('partyTime.delete');

    // mobileAndAccessories
    Route::get('/admin/mobileAndAccessories', [App\Http\Controllers\Admin\MobileAndAccessoriesController::class, 'index'])->name('mobileAndAccessories.index');
    Route::get('/admin/mobileAndAccessories/create', [App\Http\Controllers\Admin\MobileAndAccessoriesController::class, 'create'])->name('mobileAndAccessories.create');
    Route::post('/admin/mobileAndAccessories/store', [App\Http\Controllers\Admin\MobileAndAccessoriesController::class, 'store'])->name('mobileAndAccessories.store');
    Route::get('/admin/mobileAndAccessories/{id}/edit', [App\Http\Controllers\Admin\MobileAndAccessoriesController::class, 'edit'])->name('mobileAndAccessories.edit');
    Route::post('/admin/mobileAndAccessories/{id}/update', [App\Http\Controllers\Admin\MobileAndAccessoriesController::class, 'update'])->name('mobileAndAccessories.update');
    Route::get('/admin/mobileAndAccessories/{id}/delete', [App\Http\Controllers\Admin\MobileAndAccessoriesController::class, 'delete'])->name('mobileAndAccessories.delete');

    // setting
    Route::get('/admin/setting', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('setting.index');
    Route::post('/admin/setting/store', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('setting.store');
    Route::get('/admin/setting/edit', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('setting.edit');
    Route::post('/admin/setting/{id}/update', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('setting.update');
    Route::post('/upload', [App\Http\Controllers\Admin\SettingController::class, 'upload'])->name('ckeditor.update');

    // report
    Route::get('/admin/report_order', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('order_report.index');

    // Profile
    Route::get('/profile',  [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile',  [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');


    // Change Password
    Route::get('/admin/change_password', [App\Http\Controllers\Admin\PasswordController::class, 'changePassword'])->name('change_password.index');
    Route::post('/admin/change_password/store', [App\Http\Controllers\Admin\PasswordController::class, 'store'])->name('postChangePassword');

    // delivery-boy-managment
    Route::get('/admin/delivery-boy-management', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'index'])->name('delivery-boy-management.index');
    Route::get('/admin/delivery-boy-management/create', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'create'])->name('delivery-boy-management.create');
    Route::post('/admin/delivery-boy-management/store', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'store'])->name('delivery-boy-management.store');
    Route::get('/admin/delivery-boy-management/{id}/edit', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'edit'])->name('delivery-boy-management.edit');
    Route::post('/admin/delivery-boy-management/{id}/update', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'update'])->name('delivery-boy-management.update');
    Route::get('/admin/delivery-boy-management/{id}/delete', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'delete'])->name('delivery-boy-management.delete');
    Route::get('/admin/delivery-boy-management/{id}/payment', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'payment'])->name('delivery-boy-management.payment');
    Route::post('/admin/delivery-boy-management/{id}/addPayment', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'addPayment'])->name('delivery-boy-management.addPayment');
    Route::get('/admin/delivery-boy-management/{id}/paymentHistory', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'paymentHistory'])->name('delivery-boy-management.paymentHistory');
    Route::post('/admin/get-delivery-boys', [App\Http\Controllers\Admin\OrderController::class, 'updateDeliveryBoy'])->name('admin.getDeliveryBoys');
    Route::get('/admin/delivery-boy-management/{id}/orders', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'orders'])->name('delivery-boy-management.orders');
    Route::get('/admin/delivery-boy-management/{id}/view', [App\Http\Controllers\Admin\DeliveryBoyManagementController::class, 'view'])->name('delivery-boy-management.view');

    // Delivery Charge
    Route::get('/admin/deliveryCharge', [App\Http\Controllers\Admin\DeliveryChargeController::class, 'index'])->name('deliveryCharge.index');
    Route::get('/admin/deliveryCharge/create', [App\Http\Controllers\Admin\DeliveryChargeController::class, 'create'])->name('deliveryCharge.create');
    Route::post('/admin/deliveryCharge/store', [App\Http\Controllers\Admin\DeliveryChargeController::class, 'store'])->name('deliveryCharge.store');
    Route::get('/admin/deliveryCharge/{id}/edit', [App\Http\Controllers\Admin\DeliveryChargeController::class, 'edit'])->name('deliveryCharge.edit');
    Route::post('/admin/deliveryCharge/{id}/update', [App\Http\Controllers\Admin\DeliveryChargeController::class, 'update'])->name('deliveryCharge.update');
    Route::get('/admin/deliveryCharge/{id}/delete', [App\Http\Controllers\Admin\DeliveryChargeController::class, 'delete'])->name('deliveryCharge.delete');

    // Unit
    Route::get('/admin/unit', [App\Http\Controllers\Admin\UnitController::class, 'index'])->name('unit.index');
    Route::get('/admin/unit/create', [App\Http\Controllers\Admin\UnitController::class, 'create'])->name('unit.create');
    Route::post('/admin/unit/store', [App\Http\Controllers\Admin\UnitController::class, 'store'])->name('unit.store');
    Route::get('/admin/unit/{id}/edit', [App\Http\Controllers\Admin\UnitController::class, 'edit'])->name('unit.edit');
    Route::post('/admin/unit/{id}/update', [App\Http\Controllers\Admin\UnitController::class, 'update'])->name('unit.update');
    Route::get('/admin/unit/{id}/delete', [App\Http\Controllers\Admin\UnitController::class, 'delete'])->name('unit.delete');

    // Sponsored banner
    Route::get('/admin/sponsored-banner', [App\Http\Controllers\Admin\SponsoredBannerController::class, 'index'])->name('sponsored-banner.index');
    Route::get('/admin/sponsored-banner/create', [App\Http\Controllers\Admin\SponsoredBannerController::class, 'create'])->name('sponsored-banner.create');
    Route::post('/admin/sponsored-banner/store', [App\Http\Controllers\Admin\SponsoredBannerController::class, 'store'])->name('sponsored-banner.store');
    Route::get('/admin/sponsored-banner/{id}/edit', [App\Http\Controllers\Admin\SponsoredBannerController::class, 'edit'])->name('sponsored-banner.edit');
    Route::post('/admin/sponsored-banner/{id}/update', [App\Http\Controllers\Admin\SponsoredBannerController::class, 'update'])->name('sponsored-banner.update');
    Route::get('/admin/sponsored-banner/{id}/delete', [App\Http\Controllers\Admin\SponsoredBannerController::class, 'delete'])->name('sponsored-banner.delete');

    // couponCode
    Route::get('/admin/couponCode', [App\Http\Controllers\Admin\CouponCodeController::class, 'index'])->name('couponCode.index');
    Route::get('/admin/couponCode/create', [App\Http\Controllers\Admin\CouponCodeController::class, 'create'])->name('couponCode.create');
    Route::post('/admin/couponCode/store', [App\Http\Controllers\Admin\CouponCodeController::class, 'store'])->name('couponCode.store');
    Route::get('/admin/couponCode/{id}/edit', [App\Http\Controllers\Admin\CouponCodeController::class, 'edit'])->name('couponCode.edit');
    Route::post('/admin/couponCode/{id}/update', [App\Http\Controllers\Admin\CouponCodeController::class, 'update'])->name('couponCode.update');
    Route::get('/admin/couponCode/{id}/delete', [App\Http\Controllers\Admin\CouponCodeController::class, 'delete'])->name('couponCode.delete');
    
    // pincode
    Route::get('/admin/pincode', [App\Http\Controllers\Admin\PincodeController::class, 'index'])->name('pincode.index');
    Route::get('/admin/pincode/create', [App\Http\Controllers\Admin\PincodeController::class, 'create'])->name('pincode.create');
    Route::post('/admin/pincode/store', [App\Http\Controllers\Admin\PincodeController::class, 'store'])->name('pincode.store');
    Route::get('/admin/pincode/{id}/edit', [App\Http\Controllers\Admin\PincodeController::class, 'edit'])->name('pincode.edit');
    Route::post('/admin/pincode/{id}/update', [App\Http\Controllers\Admin\PincodeController::class, 'update'])->name('pincode.update');
    Route::get('/admin/pincode/{id}/delete', [App\Http\Controllers\Admin\PincodeController::class, 'delete'])->name('pincode.delete');

    Route::post('/ckeditor/upload', [App\Http\Controllers\CKEditorController::class, 'upload'])->name('ckeditor.upload');


});