<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Eksportir: produk + search + detail + apply
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('role:eksportir')
        ->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->middleware('role:eksportir')
        ->name('products.show');
    Route::post('/products/{product}/apply', [PartnershipController::class, 'apply'])
        ->middleware('role:eksportir')
        ->name('partnerships.apply');

    // Petani: produk milik sendiri + tambah produk
    Route::get('/petani/products', [ProductController::class, 'myIndex'])
        ->middleware('role:petani')
        ->name('petani.products.index');
    Route::get('/petani/products/create', [ProductController::class, 'create'])
        ->middleware('role:petani')
        ->name('petani.products.create');
    Route::post('/petani/products', [ProductController::class, 'store'])
        ->middleware('role:petani')
        ->name('petani.products.store');

    // Petani: permintaan masuk
    Route::get('/requests', [PartnershipController::class, 'requests'])
        ->middleware('role:petani')
        ->name('requests.index');
    Route::post('/requests/{id}/accept', [PartnershipController::class, 'accept'])
        ->middleware('role:petani')
        ->name('requests.accept');
    Route::post('/requests/{id}/reject', [PartnershipController::class, 'reject'])
        ->middleware('role:petani')
        ->name('requests.reject');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
