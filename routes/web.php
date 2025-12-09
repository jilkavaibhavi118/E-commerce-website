<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\CartController;
use App\Http\Controllers\Backend\CheckoutController;
use App\Http\Controllers\Backend\AdminOrderController;
use App\Http\Controllers\Frontend\OrderController as CustomerOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

 /** Roles */
 Route::group(['middleware' => ['can:roles.view']], function () {
    Route::delete('roles/destroy', [RoleController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RoleController::class)->except(['view']);
    Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::post('roles/{role}/permissions', [RoleController::class, 'permissionsStore'])->name('roles.permissions.store');
});

/** Categories */
Route::group(['middleware' => ['can:categories.view']], function () {

    Route::delete('categories/destroy', [CategoryController::class, 'massDestroy'])
        ->name('categories.massDestroy')
        ->middleware('can:categories.delete');

    Route::resource('categories', CategoryController::class)->except(['view']);
});

/** Subcategories */
Route::group(['middleware' => ['can:subcategories.view']], function () {

    Route::delete('subcategories/destroy', [SubcategoryController::class, 'massDestroy'])
        ->name('subcategories.massDestroy')
        ->middleware('can:subcategories.delete');

    Route::resource('subcategories', SubcategoryController::class);
});

/** AJAX API for Subcategories */
Route::get('api/subcategories/by-category/{category}', [SubcategoryController::class, 'byCategory'])
    ->name('api.subcategories.byCategory');

/** Products */
Route::group(['middleware' => ['can:products.view']], function () {

    Route::delete('products/destroy', [ProductController::class, 'massDestroy'])
        ->name('products.massDestroy')
        ->middleware('can:products.delete'); // FIXED

    Route::resource('products',  ProductController::class)->except(['view']);
});

/** Brands */
Route::group(['middleware' => ['can:brands.view']], function () {
    Route::resource('brands', BrandController::class)
        ->except(['view']);
});

/** Brands */
Route::group(['middleware' => ['can:coupons.view']], function () {
    Route::resource('coupons', CouponController::class)
        ->except(['view']);
});

/** Customer */
Route::group(['middleware' => ['can:customers.view']], function () {
    Route::resource('customers', CustomerController::class)
        ->except(['view']);
});

Route::middleware('auth')->group(function () {

    // CART
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // APPLY COUPON
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');

    // CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
});

Route::get('/dashboard', function () {
    return view('frontend.dashboard');
})->middleware('auth')->name('user.dashboard');

Route::get('/dashboard', function () {
    return view('frontend.dashboard');
})->middleware('auth')->name('user.dashboard');


Route::middleware(['auth', 'can:orders.view'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // All CRUD routes for orders
        Route::resource('orders', AdminOrderController::class);

        // Update order status
        Route::post('/orders/{order}/status', 
            [AdminOrderController::class, 'updateStatus']
        )->name('orders.updateStatus');
});

Route::middleware('auth')
    ->prefix('orders')
    ->name('user.orders.')
    ->group(function () {

        Route::get('/', [CustomerOrderController::class, 'index'])
            ->name('index');

        Route::get('/{order}', [CustomerOrderController::class, 'show'])
            ->name('show');
});

require __DIR__.'/auth.php';
