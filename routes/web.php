<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductRecommendationController;
use App\Http\Controllers\Admin\TrustedFarmerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\PremiumVerificationController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\PartnershipDetailController;
use App\Http\Controllers\PartnershipHistoryController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// routes/web.php

Route::get('/', LandingController::class);

Route::get('/about', function () {
    return view('about');
});

Route::get('/statistik', function () {
    return view('statistik');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/dashboard/farmer', [DashboardController::class, 'farmer'])
        ->middleware('role:farmer')
        ->name('dashboard.farmer');
    Route::get('/dashboard/exporter', [DashboardController::class, 'exporter'])
        ->middleware('role:exporter')
        ->name('dashboard.exporter');
    // Eksportir: produk + search + detail + apply
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('role:exporter')
        ->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->middleware('role:exporter')
        ->name('products.show');
    Route::post('/products/{product}/apply', [PartnershipController::class, 'apply'])
        ->middleware('role:exporter')
        ->name('partnerships.apply');
    Route::get('/partnerships/history', [PartnershipHistoryController::class, 'index'])
        ->middleware('role:farmer,exporter')
        ->name('partnerships.history');
    Route::get('/partnerships/{partnership}', [PartnershipDetailController::class, 'show'])
        ->middleware('role:farmer,exporter')
        ->name('partnerships.show');
    Route::post('/partnerships/{partnership}/advance', [PartnershipDetailController::class, 'advanceStage'])
        ->middleware('role:farmer')
        ->name('partnerships.advance');
    Route::post('/partnerships/{partnership}/transactions', [PartnershipDetailController::class, 'storeTransaction'])
        ->middleware('role:farmer,exporter')
        ->name('partnerships.transactions.store');
    Route::post('/partnerships/{partnership}/documents', [PartnershipDetailController::class, 'storeDocument'])
        ->middleware('role:farmer,exporter')
        ->name('partnerships.documents.store');
    Route::get('/partnerships/{partnership}/documents/{document}', [PartnershipDetailController::class, 'downloadDocument'])
        ->middleware('role:farmer,exporter')
        ->name('partnerships.documents.download');
    Route::post('/partnerships/{partnership}/review', [PartnershipDetailController::class, 'storeReview'])
        ->middleware('role:exporter')
        ->name('partnerships.review');
    Route::patch('/partnerships/{partnership}/contract', [PartnershipDetailController::class, 'updateContract'])
        ->middleware('role:farmer')
        ->name('partnerships.contract.update');

    Route::get('/premium/upgrade', [PremiumController::class, 'upgrade'])->name('premium.upgrade');
    Route::post('/premium/verify', [PremiumController::class, 'submitVerification'])
        ->middleware('role:farmer')
        ->name('premium.verify');
    Route::get('/premium/insight', fn () => view('premium.insight'))
        ->middleware(['role:farmer,exporter', 'premium'])
        ->name('premium.insight');
    Route::post('/products/{product}/favorite', [FavoriteController::class, 'toggle'])
        ->middleware('role:exporter')
        ->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->middleware('role:exporter')
        ->name('favorites.index');

    // Petani: produk milik sendiri + tambah produk
    Route::get('/petani/products', [ProductController::class, 'myIndex'])
        ->middleware('role:farmer')
        ->name('petani.products.index');
    Route::get('/petani/products/create', [ProductController::class, 'create'])
        ->middleware('role:farmer')
        ->name('petani.products.create');
    Route::post('/petani/products', [ProductController::class, 'store'])
        ->middleware('role:farmer')
        ->name('petani.products.store');
    Route::get('/petani/products/{product}/edit', [ProductController::class, 'edit'])
         ->middleware('role:farmer')
        ->name('petani.products.edit');
    Route::patch('/petani/products/{product}', [ProductController::class, 'update'])
        ->middleware('role:farmer')
        ->name('petani.products.update');
    Route::delete('/petani/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('role:farmer')
        ->name('petani.products.destroy');

    // Petani: permintaan masuk
    Route::get('/requests', [PartnershipController::class, 'requests'])
        ->middleware('role:farmer')
        ->name('requests.index');
    Route::post('/requests/{id}/accept', [PartnershipController::class, 'accept'])
        ->middleware('role:farmer')
        ->name('requests.accept');
    Route::post('/requests/{id}/reject', [PartnershipController::class, 'reject'])
        ->middleware('role:farmer')
        ->name('requests.reject');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Admin Dashboard Basic
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/recommendations', [ProductRecommendationController::class, 'index'])->name('recommendations.index');
        Route::post('/products/{product}/recommend', [ProductRecommendationController::class, 'toggle'])->name('recommendations.toggle');

        Route::get('/trusted-farmers', [TrustedFarmerController::class, 'index'])->name('trusted-farmers.index');
        Route::post('/farmers/{user}/trust', [TrustedFarmerController::class, 'toggle'])->name('trusted-farmers.toggle');

        Route::get('/premium-verifications', [PremiumVerificationController::class, 'index'])->name('premium-verifications.index');
        Route::post('/premium-verifications/{user}/approve', [PremiumVerificationController::class, 'approve'])->name('premium-verifications.approve');
        Route::post('/premium-verifications/{user}/reject', [PremiumVerificationController::class, 'reject'])->name('premium-verifications.reject');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

