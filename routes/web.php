<?php

use App\Http\Controllers\Client\PharmacyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Admin\ManageOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\FilterController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RedirectController;




/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/', [UserController::class, 'Index'])->name('index');



Route::get('/dashboard', function () {
    return view('frontend.dashboard.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile/store', [UserController::class, 'ProfileStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/change/password', [UserController::class, 'ChangePassword'])->name('change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
    
    //unutk get data wishlist for user
    Route::get('/all/wishlist', [HomeController::class, 'AllWishList'])->name('all.wishlist');
    Route::get('/remove/wishlist/{id}', [HomeController::class, 'RemoveWishList'])->name('remove.wishlist');
    //order
    Route::controller(ManageOrderController::class)->group(function () {
        Route::get('/user/order/list', 'UserOrderList')->name('user.order.list');
        Route::get('/user/order/details/{id}', 'UserOrderDetails')->name('user.order.details');
        Route::get('/user/invoice/download/{id}', 'UserInvoiceDownload')->name('user.invoice.download');

    
    });
});



require __DIR__.'/auth.php';

//REQUIRE LOGGING AND ADMIN
Route::middleware('admin')->group(function(){
    Route::get('/admin/dashboard', [AdminController::class,
    'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [ AdminController::class,
    'AdminProfile' ])->name('admin.profile');
    Route::post('/admin/profile/store', [
        AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [
        AdminController::class,'AdminChangePassword' ])->name('admin.change.password');
    Route::post('/admin/password/update', [
        AdminController::class,
        'AdminPasswordUpdate'])->name('admin.password.update');
});


Route::get('/admin/login',[AdminController::class, 'AdminLogin'])->name('admin.login');

Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

Route::get('/admin/forget_password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget_password');

Route::post('/admin/password_submit', [AdminController::class, 'AdminPasswordSubmit'])->name('admin.password_submit');

Route::get('/admin/reset-password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);

Route::post('/admin/admin.reset_password_submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');

//ALL ROUTE FOR CLIENT


//REQUIRE LOGGING AND CLIENT
Route::middleware('client')->group(function () {
    Route::get('/client/dashboard', [
        ClientController::class,
        'ClientDashboard'
    ])->name('client.dashboard');
    Route::get('/client/profile', [
        ClientController::class,
        'ClientProfile'
    ])->name('client.profile');
    Route::post('/client/profile/store', [
        ClientController::class,
        'ClientProfileStore'
    ])->name('client.profile.store');
    Route::get('/client/change/password', [
        ClientController::class,
        'ClientChangePassword'
    ])->name('client.change.password');
    Route::post('/client/password/update', [
        ClientController::class,
        'ClientPasswordUpdate'
    ])->name('client.password.update');
});

Route::post('/client/register/submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.register.submit');

Route::get('/client/login',[ClientController::class, 'ClientLogin'])->name('client.login');

Route::post('/client/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');


Route::get('/client/forget_password', [ClientController::class, 'ClientForgetPassword'])->name('client.forget_password');


Route::get('/client/register',[ClientController::class, 'ClientRegister'])->name('client.register');

Route::post('/client/password_submit', [ClientController::class, 'ClientPasswordSubmit'])->name('client.password_submit');

Route::get('/client/reset-password/{token}/{email}', [ClientController::class, 'ClientResetPassword']);

Route::post('/client/client.reset_password_submit', [ClientController::class, 'ClientResetPasswordSubmit'])->name('client.reset_password_submit');

Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');

///All Admin Category
Route::middleware('admin')->group(function () {

    Route::controller(CategoryController::class)->group(function(){
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('category.store');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category}', 'UpdateCategory')->name('category.update');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');



    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/city', 'AllCity')->name('all.city');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/city', 'StoreCity')->name('city.store');
        Route::get('/edit/city/{id}', 'EditCity');
        Route::post('/update/city}', 'UpdateCity')->name('city.update');
        Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');




    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('/admin/all/unit', 'AdminAllUnit')->name('admin.all.unit');
        Route::get('/admin/add/unit', 'AdminAddUnit')->name('admin.add.unit');
        Route::post('/admin/store/unit', 'AdminStoreUnit')->name('admin.store.unit');
        Route::get('/admin/edit/unit/{id}', 'AdminEditUnit')->name('admin.edit.unit');
        Route::post('/admin/update/unit', 'AdminUpdateUnit')->name('admin.update.unit');
        Route::get('/admin/delete/unit/{id}', 'AdminDeleteUnit')->name('admin.delete.unit');

    });


    Route::controller(ManageController::class)->group(function () {
        Route::get('/pending/pharmacy', 'PendingPharmacy')->name('pending.pharmacy');
        Route::get('/clientchangeStatus', 'ClientChangeStatus');
        Route::get('/approve/pharmacy', 'ApprovePharmacy')->name('approve.pharmacy');



    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('/all/banner', 'AllBanner')->name('all.banner');
        Route::post('/banner/store', 'BannerStore')->name('banner.store');
        Route::get('/edit/banner/{id}', 'EditBanner');
        Route::post('/banner/update', 'BannerUpdate')->name('banner.update');
        Route::get('/delete/banner{id}', 'DeleteBanner')->name('delete.banner');


    });

    Route::controller(ManageOrderController::class)->group(function () {
        Route::get('/admin/pending/order', 'AdminPendingOrder')->name('admin.pending.order');
        Route::get('/admin/confirm/order', 'AdminConfirmedOrder')->name('admin.confirmed.order');
        Route::get('/admin/processing/order', 'AdminProcessingOrder')->name('admin.processing.order');
        Route::get('/admin/delivered/order', action: 'AdminDeliveredOrder')->name('admin.delivered.order');
        Route::get('/admin/order/details{id}', action: 'AdminOrderDetails')->name('admin.order_details');
    });

    Route::controller(ManageOrderController::class)->group(function () {
        Route::get('/admin/pending_to_confirm/{id}', 'AdminPendingToConfirm')->name('admin.pending_to_confirm');
        Route::get('/admin/confirm_to_process/{id}', 'AdminConfirmToProcess')->name('admin.confirm_to_process');
        Route::get('/admin/process_to_delivered/{id}', 'AdminProcessToDelivered')->name('admin.process_to_delivered');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/admin/all/reports', 'AdminAllReports')->name('admin.all.reports');
        Route::post('/admin/search/bydate', 'AdminSearchBydate')->name('admin.search.bydate');
        Route::post('/admin/search/bymonth', 'AdminSearchBymonth')->name('admin.search.bymonth');
        Route::post('/admin/search/byYear', 'AdminSearchByYear')->name('admin.search.byYear');

    });

    Route::controller(ReviewController::class)->group(function () {
        Route::get('admin/pending/review', 'AdminPendingReview')->name('admin.pending.review');
        Route::get('admin/approve/review', 'AdminApproveReview')->name('admin.approve.review');
        Route::get('/reviewchangeStatus', 'ReviewChangeStatus');

    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('permission.store');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('permission.update');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');



    });


});
// END ADMIN MIDDLEWARE

Route::middleware(['status', 'client'])->group(function () {

    Route::controller(PharmacyController::class)->group(function(){

        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/store/product', 'StoreProduct')->name('store.product');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/update/product', 'UpdateProduct')->name('update.product');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');
        

    });

    Route::controller(PharmacyController::class)->group(function(){
        Route::get('/all/unit', 'AllUnit')->name('all.unit');
        Route::get('/add/unit', 'AddUnit')->name('add.unit');
        Route::post('/store/unit', 'StoreUnit')->name('store.unit');
        Route::get('/edit/unit/{id}', 'EditUnit')->name('edit.unit');
        Route::post('/update/unit', 'UpdateUnit')->name('update.unit');
        Route::get('/delete/unit/{id}', 'DeleteUnit')->name('delete.unit');
        Route::get('/changeStatus', 'ChangeStatus');

    });


    Route::controller(PharmacyController::class)->group(function () {
        Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
        Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
        Route::post('/store/gallery', 'StoreGallery')->name('store.gallery');
        Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
        Route::post('/update/gallery', 'UpdateGallery')->name('update.gallery');
        Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');

    });




    Route::controller(CouponController::class)->group(function () {
        Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('store.coupon');
        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon', 'UpdateCoupon')->name('update.coupon');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');

    });

    Route::controller(ManageOrderController::class)->group(function () {
        Route::get('/all/client/orders', 'AllClientOrders')->name('all.client.orders');
        Route::get('/client/pending/order', 'ClientPendingOrder')->name('client.pending.order');
        Route::get('/client/confirm/order', 'ClientConfirmedOrder')->name('client.confirmed.order');
        Route::get('/client/processing/order', 'ClientProcessingOrder')->name('client.processing.order');
        Route::get('/client/delivered/order', action: 'ClientDeliveredOrder')->name('client.delivered.order');
        Route::get('/all/client/orders/details/{id}','ClientOrderDetails',)->name('client.order_details');

    });

    Route::controller(ManageOrderController::class)->group(function () {
        Route::get('/client/pending_to_confirm/{id}', 'ClientPendingToConfirm')->name('client.pending_to_confirm');
        Route::get('/client/confirm_to_process/{id}', 'ClientConfirmToProcess')->name('client.confirm_to_process');
        Route::get('/client/process_to_delivered/{id}', 'ClientProcessToDelivered')->name('client.process_to_delivered');
        
    });

    

    Route::controller(ReportController::class)->group(function () {
        Route::get('/admin/all/reports', 'AdminAllReports')->name('admin.all.reports');
        Route::post('/admin/search/bydate', 'AdminSearchBydate')->name('admin.search.bydate');
        Route::post('/admin/search/bymonth', 'AdminSearchBymonth')->name('admin.search.bymonth');
        Route::post('/admin/search/byYear', 'AdminSearchByYear')->name('admin.search.byYear');

    });

    Route::controller(ReviewController::class)->group(function () {
        Route::get('admin/pending/review', 'AdminPendingReview')->name('admin.pending.review');
        Route::get('admin/approve/review', 'AdminApproveReview')->name('admin.approve.review');
        Route::get('/reviewchangeStatus', 'ReviewChangeStatus');

    });


    Route::controller(ReportController::class)->group(function () {
        Route::get('/client/all/reports', 'ClientAllReports')->name('client.all.reports');
        Route::post('/client/search/bydate', 'ClientSearchBydate')->name('client.search.bydate');
        Route::post('/client/search/bymonth', 'ClientSearchBymonth')->name('client.search.bymonth');
        Route::post('/client/search/byYear', 'ClientSearchByYear')->name('client.search.byYear');

    });

    Route::controller(ReviewController::class)->group(function () {
        Route::get('client/pending/review', 'ClientPendingReview')->name('client.pending.review');
        Route::get('client/approve/review', 'ClientApproveReview')->name('client.approve.review');
        Route::get('/reviewchangeStatus', 'ReviewChangeStatus');

    });
    
});
// End Client Middleware


//all user can
Route::get('/changeStatus',[PharmacyController::class, 'ChangeStatus']);


Route::controller(HomeController::class)->group(function () {
    Route::get('/pharmacy/details/{id}', 'PharmacyDetails')->name('phm.details');
    Route::post('/add-wish-list/{id}', 'AddWishList');
    Route::get('/view/unit/{id}', 'ViewUnit')->name('view_unit');


});

Route::controller(CartController::class)->group(function () {
    Route::get('/add_to_cart/{id}', 'AddToCart')->name('add_to_cart');
    Route::post('/cart/update-quantity', 'updateCartQuatity')->name('cart.updateQuantity');
    Route::post('/cart/remove', 'CartRemove')->name('cart.remove');
    Route::post('/apply-coupon', 'ApplyCoupon');
    Route::get('/remove-coupon', 'RemoveCoupon');
    Route::get('/checkout', 'PharmCheckout')->name('checkout')->middleware('auth');


});

Route::controller(OrderController::class)->group(function () {
    Route::post('/cash_order', 'CashOrder')->name('cash_order');
    Route::post('/stripe_order', 'StripeOrder')->name('stripe_order');

});

Route::controller(ReviewController::class)->group(function () {
    Route::post('/store/review', 'StoreReview')->name('store.review');
    
});

Route::controller(FilterController::class)->group(function () {
    Route::get('/list/pharmacy', 'ListPharmacy')->name('list.pharmacy');
    Route::get('/filter/unit', 'FilterUnit')->name('filter.units');

});

Route::controller(RatingController::class)->group(function () {
    Route::get('/rating/{id}', 'Rating')->name('rating');
    Route::get('/rating/view/{id}', 'RatingView')->name('viewrating');
    Route::get('/leave/rating/{id}', 'LeaveRating')->name('leave.rating')->middleware('auth');
    Route::post('/store/rating', 'StoreRating')->name('store.rating');

});












