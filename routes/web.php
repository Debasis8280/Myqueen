<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminBarcodeController;
use App\Http\Controllers\Admin\AdminBranchController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminForcastController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPromotionController;
use App\Http\Controllers\Admin\AdminReturnController;
use App\Http\Controllers\Admin\AdminShippingChargeController;
use App\Http\Controllers\Admin\AdminUserProfileController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MLM\MLMDirectBonus;
use App\Http\Controllers\MLM\MLMMatchingBonusController;
use App\Http\Controllers\MLM\MLMRegisterController;
use App\Http\Controllers\MLM\MLMTreeController;
use App\Http\Controllers\User\UserAddressController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserCouponController;
use App\Http\Controllers\User\UserDeliveryChargeController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserPaymentController;
use App\Http\Controllers\User\UserProductsController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserPurchaseHistoryController;
use App\Http\Controllers\User\UserThanksController;
use App\Http\Controllers\User\UserWalletController;
use App\Http\Controllers\User\UserWelcomeController;
use App\Http\Controllers\User\UserWishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



// for all country
use PragmaRX\Countries\Package\Countries;

Route::get('/country_list', function () {
    $countries = new Countries();
    $all = $countries->all()->pluck('name.common')->toArray();
    echo json_encode($all);
})->name('get_all_country');


Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::resource('/Dashboard', AdminDashboardController::class)->names([
        'index' => 'dashboard.index'
    ]);



    Route::post('/delete_warehouse', [AdminInventoryController::class, 'delete_ware_house'])->name('ware_house.delete');
    Route::post('/addWarehouse', [AdminInventoryController::class, 'addWarehouse'])->name('addWarehouse');
    Route::get('/showWareHouse', [AdminInventoryController::class, 'showWareHouse'])->name('showWareHouse');
    Route::post('/addRack', [AdminInventoryController::class, 'addRack'])->name('addRack');
    Route::get('/warehouse_with_rack', [AdminInventoryController::class, 'showRack'])->name('showRack');
    Route::get('/getAllWarehouseDetails', [AdminInventoryController::class, 'getAllWarehouseDetails'])->name('getAllWarehouseDetails');
    Route::get('/showeditinventory', [AdminInventoryController::class, 'showeditinventoryData'])->name('showeditinventoryData');
    Route::post('/updateInventory', [AdminInventoryController::class, 'updateInventory'])->name('updateInventory');
    Route::post('/inventory/delete', [AdminInventoryController::class, 'deleteInventory'])->name('inventory.delete');
    Route::resource('inventory', AdminInventoryController::class)->names([
        'index'     => 'inventory.index',
        'store'     => 'inventory.store',
        'create'    => 'inventory.create',
    ]);


    Route::get('/getReturnData', [AdminReturnController::class, 'showReturnDataById'])->name('return.showData');
    Route::post('/updateRetutn', [AdminReturnController::class, 'updateReturn'])->name('return.updateReturn');
    Route::post('/deleteRetutn', [AdminReturnController::class, 'deleteReturn'])->name('retutn.delete');
    Route::resource('product/return', AdminReturnController::class)->names([
        'index' => 'return.index',
        'store' => 'return.store',
        'create' => 'return.create'
    ]);


    Route::resource('forcast', AdminForcastController::class)->names([
        'index' => 'forcast.index'
    ]);


    Route::get('category/showEditData', [AdminCategoryController::class, 'showEditData'])->name('category.showEditData');
    Route::post('categoty/update', [AdminCategoryController::class, 'updateCategory'])->name('category.updateCategory');
    Route::post('/deleteCategory', [AdminCategoryController::class, 'deleteCategory'])->name('category.deleteCategory');
    Route::resource('category', AdminCategoryController::class)->names([
        'index' => 'category.index',
        'store' => 'category.store'
    ]);

    Route::post('/get_edit_data', [AdminProductController::class, 'get_edit_data'])->name('product.get_edit_data')->middleware('signed');
    Route::post('/deleteProduct', [AdminProductController::class, 'deleteProduct'])->name('product.deleteProduct');
    Route::get('ad_categoryList', [AdminProductController::class, 'categoryList'])->name('product.categoryList');
    Route::resource('/adminproduct', AdminProductController::class)->names([
        'index'  => 'product.index',
        'create' => 'product.create',
        'edit'   => 'product.edit',
        'store'  => 'product.store',
        'update' => 'products.update'
    ]);

    Route::get('/showEditData', [AdminBranchController::class, 'showEditData'])->name('branch.showEditData');
    Route::post('updateBranch', [AdminBranchController::class, 'updateBranch'])->name('branch.updateBranch');
    Route::post('deleteBranch', [AdminBranchController::class, 'deleteBranch'])->name('branch.delete');
    Route::resource('branch', AdminBranchController::class)->names([
        'index' => 'branch.index',
        'store' => 'branch.store'
    ]);



    // coupon 
    Route::post('/deleteCoupon', [AdminCouponController::class, 'deleteCoupon'])->name('coupon.delete');
    Route::resource('coupon', AdminCouponController::class)->names([
        'index'     => 'coupon.index',
        'store'     => 'coupon.store',
        'create'    => 'coupon.create',
    ]);
    // end coupon

    // shipping charge
    Route::post('/deleteShipc', [AdminShippingChargeController::class, 'deleteShipc'])->name('shipc.delete');
    Route::resource('shipping_charge', AdminShippingChargeController::class)->names([
        'index'     => 'shipc.index',
        'store'     => 'shipc.store',
        'create'    => 'shipc.create',
    ]);
    // end shipping charge

    // barcode
    Route::get('/show_Barcode', [AdminBarcodeController::class, 'index'])->name('barcode.index');
    Route::get('/barcodelist', [AdminBarcodeController::class, 'barcodeList'])->name('barcode.barcodeList');
    Route::get('barcodeImage', [AdminBarcodeController::class, 'barcodeImage'])->name('barcode.barcodeImage');
    Route::get('/barcodedownload', [AdminBarcodeController::class, 'download'])->name('barcode.download');
    // end barcode

    // banner
    Route::post('/deleteBanner', [AdminBannerController::class, 'deleteBanner'])->name('banner.deleteBanner');
    Route::resource('banner', AdminBannerController::class)->names([
        'index'     => 'banner.index',
        'create'    => 'banner.create',
        'store'     => 'banner.store'
    ]);
    // end banner

    // user
    Route::post('/userDetails', [AdminUsersController::class, 'getUserDetails'])->name('users.getUserDetails');
    Route::post('/updateUser', [AdminUsersController::class, 'updateUser'])->name('users.updateUser');
    Route::post('/deleteUser', [AdminUsersController::class, 'deleteUser'])->name('users.deleteUser');
    Route::resource('user', AdminUsersController::class)->names([
        'index'  => 'users.index',
        'create' => 'users.create'
    ]);
    // end user


    // order details
    Route::get('/download_invoice/{id}', [AdminOrderController::class, 'downloadInvoic'])->name('download.order.invoice');
    Route::get('/ad_order_detils/{id}', [AdminOrderController::class, 'show_order_details'])->name('show_order_details');
    Route::post('delete_order', [AdminOrderController::class, 'delete_Order'])->name('delete_order')->middleware('signed');
    Route::resource('ad_all_orders', AdminOrderController::class)->names([
        'index'     => 'orders.index',
        'create'    => 'orders.create',
        'store'     => 'orders.change_status'
    ])->middleware('signed');
    Route::resource('order', 'OrderController')->middleware('auth');
    // end order details

    // invoice
    Route::resource('invoice', AdminInvoiceController::class)->names([
        'show' => 'invoice.show'
    ]);
    // end invoice

    // start promotion
    Route::post('/delete_promotion_Banner', [AdminPromotionController::class, 'delete_Banner'])->name('promotion.delete_Banner')->middleware('signed');
    Route::resource('promotion', AdminPromotionController::class)->names([
        'index' => 'promotion.index',
        'store' => 'promotion.store',
        'create' => 'promotion.create'
    ])->middleware('signed');
    // end promotion

    // payment
    Route::get('payment_details/{id}', [AdminPaymentController::class, 'show'])->name('payment.show_details');
    Route::resource('payment', AdminPaymentController::class)->names([
        'index' => 'payment.index',
        'create' => 'payment.create',
        'store' => 'payment.store.approve'
    ])->middleware('signed');
    // end payment

    Route::get('ad_user_profile/{id}', [AdminUserProfileController::class, 'show'])->name('profile.show');
});

// language change
Route::get('/change_language/{lang}', [LanguageController::class, 'changeLanguage'])->name('change.lang');


// for user operation

Route::get('/', [UserWelcomeController::class, 'index'])->name('users.index')->middleware('LangSwitch');
Route::get('/about-us', [UserWelcomeController::class, 'about_us'])->name('users.aboutus');
Route::get('/contact-us', [UserWelcomeController::class, 'contact_us'])->name('users.contactus');

Route::get('/index_item', [UserWelcomeController::class, 'create'])->name('users.index.item')->middleware(['LangSwitch']);
Route::get('/get_all_product', [UserWelcomeController::class, 'get_all_product'])->name('users.all_product')->middleware(['LangSwitch', 'signed']);
Route::get('/product-list', [UserWelcomeController::class, 'view_product_list'])->name('users.view_product_list')->middleware(['signed', 'LangSwitch']);
Route::get('/product-details/{id}', [UserProductsController::class, 'show'])->name('users.product_details.show')->middleware(['signed', 'LangSwitch']);
Route::get('/product_details', [UserProductsController::class, 'index'])->name('user.product_details.index');
Route::post('get_product_details', [UserProductsController::class, 'create'])->name('user.product_details.create')->middleware(['signed', 'LangSwitch']);
Route::get('/show_product_rating', [UserProductsController::class, 'show_product_rating'])->name('users.product_details.show_product_rating');

Route::middleware(['auth', 'LangSwitch'])->name('users.')->group(function () {
    Route::resource('product-details', UserProductsController::class)->names([
        'store' => 'product_details.rating.store'
    ])->middleware('signed');

    Route::post('update_cart', [UserCartController::class, 'update_cart'])->name('update.cart')->middleware('signed');
    Route::post('delete_from_cart', [UserCartController::class, 'delete_from_cart'])->name('delete.cart')->middleware('signed');
    Route::resource('cart', UserCartController::class)->names([
        'store'     => 'cart.store',
        'create'    => 'cart.create',
        'index'     => 'cart.index'
    ])->middleware('signed');

    Route::resource('whishlist', UserWishlistController::class)->names([
        'index'   => 'wishlist.index',
        'store'   => 'wishlist.store',
        'create'  => 'wishlist.create'
    ])->middleware('signed');

    Route::resource('address', UserAddressController::class)->names([
        'create' => 'address.create'
    ])->middleware('signed');

    Route::post('/validate_form', [UserOrderController::class, 'validate_form'])->name('order.validate_form')->middleware('signed');
    Route::resource('order', UserOrderController::class)->names([
        'store' => 'order.store'
    ])->middleware('signed');

    Route::resource('coupon', UserCouponController::class)->names([
        'store' => 'coupon.store'
    ])->middleware('signed');

    Route::resource('delivery_charge', UserDeliveryChargeController::class)->names([
        'store' => 'delivery_charge.store'
    ])->middleware('signed');

    Route::resource('payment_option', UserPaymentController::class)->names([
        'store' => 'payment_option.store'
    ])->middleware('signed');

    Route::get('/redirect_thanks', [UserThanksController::class, 'index'])->name('thank.index');
    Route::resource('thanks', UserThanksController::class)->names([
        'show' => 'thank.show',
    ])->middleware('signed');


    Route::get('purchase_history', [UserPurchaseHistoryController::class, 'index'])->name('purchase_history.index');
    Route::resource('shoW_purchase_history', UserPurchaseHistoryController::class)->names([
        'show' => 'purchase_history.show'
    ])->middleware('signed');

    Route::get('/show_royalty', [UserWalletController::class, 'show_royalty_page'])->name('show_royalty')->middleware('signed');
    Route::post('get_pv_history', [UserProfileController::class, 'get_pv_point_history'])->name('profile.get_pv_point_history')->middleware('signed');
    Route::resource('user_profile', UserProfileController::class)->names([
        'index' => 'profile.index',
        'store' => 'profile.store'
    ])->middleware('signed');
});


Route::middleware(['auth', 'LangSwitch'])->name('MLM.')->prefix('MLM')->group(function () {

    Route::get('/search_user', [MLMRegisterController::class, 'search_user'])->name('register.search_user');
    Route::post('/check_user_status', [MLMRegisterController::class, 'check_user_status'])->name('register.check_user_status')->middleware('signed');
    Route::post('get_placement_id', [MLMRegisterController::class, 'get_placement_id'])->name('register.get_placement_id')->middleware('signed');
    Route::post('/get_pv_point', [MLMRegisterController::class, 'get_pv_point'])->middleware('signed')->name('register.get_pv_point');
    Route::post('/get_placement', [MLMRegisterController::class, 'get_placement'])->name('register.get_placement')->middleware('signed');
    Route::resource('mlm_register', MLMRegisterController::class)->names([
        'index'  => 'register.index',
        'create' => 'register.create',
        'store'  => 'register.store'
    ])->middleware('signed');


    Route::resource('tree', MLMTreeController::class)->names([
        'index' => 'tree.index',
        'create' => 'tree.create'
    ])->middleware('signed');

    Route::resource('direct-bonus', MLMDirectBonus::class)->names([
        'index' => 'direct_bonus.index',
        'create' => 'direct_bonus.create'
    ])->middleware('signed');


    Route::resource('matching-bonus', MLMMatchingBonusController::class)->names([
        'index' => 'matching_bonus.index',
        'create' => 'matching_bonus.create'
    ])->middleware('signed');
});




Route::get('/d', function () {
    return view('admin.users.user_profile');
});



require __DIR__ . '/auth.php';