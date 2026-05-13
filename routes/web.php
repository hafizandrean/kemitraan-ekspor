<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// routes/web.php

Route::get('/', function () {
    return view('landing');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/statistik', function () {
    return view('statistik');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

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
    Route::post('/products/{product}/favorite', [FavoriteController::class, 'toggle'])
        ->middleware('role:eksportir')
        ->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->middleware('role:eksportir')
        ->name('favorites.index');

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

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

