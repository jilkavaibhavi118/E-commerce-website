<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubcategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
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

    // Mass delete subcategories (optional)
    Route::delete('subcategories/destroy', [SubcategoryController::class, 'massDestroy'])
        ->name('subcategories.massDestroy')
        ->middleware('can:subcategories.delete');

    // Resource routes for CRUD
    Route::resource('subcategories', SubcategoryController::class)->except(['show']);
});



require __DIR__.'/auth.php';
