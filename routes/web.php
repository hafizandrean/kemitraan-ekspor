<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductRecommendationController;
use App\Http\Controllers\Admin\TrustedPetaniController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\SubscriptionAdminController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\PartnershipDetailController;
use App\Http\Controllers\PartnershipHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

// routes/web.php

Route::get('/', LandingController::class);

Route::get('/about', function () {
    return view('about');
});

Route::get('/statistik', function () {
    return view('statistik');
});

Route::post('/payment/callback', [App\Http\Controllers\SubscriptionController::class, 'callback'])->name('payment.callback');

Route::middleware(['auth', 'not_suspended'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/dashboard/petani', [DashboardController::class, 'petani'])
        ->middleware('role:petani')
        ->name('dashboard.petani');
    Route::get('/dashboard/eksportir', [DashboardController::class, 'eksportir'])
        ->middleware('role:eksportir')
        ->name('dashboard.eksportir');
    // Eksportir: produk + search + detail + apply
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('role:eksportir')
        ->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->middleware('role:eksportir')
        ->name('products.show');
    Route::post('/products/{product}/apply', [PartnershipController::class, 'apply'])
        ->middleware(['role:eksportir', 'not_suspended'])
        ->name('partnerships.apply');

<<<<<<< Updated upstream
    Route::middleware(['not_suspended', 'premium_exporter'])->group(function () {
=======
    Route::middleware('not_suspended')->group(function () {
>>>>>>> Stashed changes
        Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
        Route::post('/chat/start', [App\Http\Controllers\ChatController::class, 'start'])->name('chat.start');
        Route::post('/chat/report', [App\Http\Controllers\ChatReportController::class, 'store'])->name('chat.report');
        Route::get('/chat/{conversation}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{conversation}', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    });

    Route::get('/partnerships/history', [PartnershipHistoryController::class, 'index'])
        ->middleware('role:petani,eksportir')
        ->name('partnerships.history');
    Route::get('/partnerships/{partnership}', [PartnershipDetailController::class, 'show'])
        ->middleware('role:petani,eksportir')
        ->name('partnerships.show');
    Route::post('/partnerships/{partnership}/advance', [PartnershipDetailController::class, 'advanceStage'])
        ->middleware('role:petani')
        ->name('partnerships.advance');
    Route::post('/partnerships/{partnership}/transactions', [PartnershipDetailController::class, 'storeTransaction'])
        ->middleware('role:petani,eksportir')
        ->name('partnerships.transactions.store');
    Route::post('/partnerships/{partnership}/documents', [PartnershipDetailController::class, 'storeDocument'])
        ->middleware('role:petani,eksportir')
        ->name('partnerships.documents.store');
    Route::get('/partnerships/{partnership}/documents/{document}', [PartnershipDetailController::class, 'downloadDocument'])
        ->middleware('role:petani,eksportir')
        ->name('partnerships.documents.download');
    Route::post('/partnerships/{partnership}/review', [PartnershipDetailController::class, 'storeReview'])
        ->middleware('role:eksportir')
        ->name('partnerships.review');
    Route::patch('/partnerships/{partnership}/contract', [PartnershipDetailController::class, 'updateContract'])
        ->middleware('role:petani')
        ->name('partnerships.contract.update');

    Route::get('/premium', [SubscriptionController::class, 'index'])->name('premium.index');
    Route::get('/premium/upgrade', [SubscriptionController::class, 'index'])->name('premium.upgrade');
    Route::get('/premium/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('premium.checkout');
    Route::post('/premium/simulate-payment', [SubscriptionController::class, 'simulatePayment'])->name('premium.simulate-payment');
    Route::get('/subscription/history', [SubscriptionController::class, 'history'])->name('subscription.history');


    Route::get('/premium/insight', fn () => view('premium.insight'))
        ->middleware(['role:petani,eksportir', 'premium'])
        ->name('premium.insight');
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
    Route::get('/petani/products/{product}/edit', [ProductController::class, 'edit'])
         ->middleware('role:petani')
        ->name('petani.products.edit');
    Route::patch('/petani/products/{product}', [ProductController::class, 'update'])
        ->middleware('role:petani')
        ->name('petani.products.update');
    Route::delete('/petani/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('role:petani')
        ->name('petani.products.destroy');

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

        Route::get('/trusted-petani', [TrustedPetaniController::class, 'index'])->name('trusted-farmers.index');
        Route::post('/petani/{user}/trust', [TrustedPetaniController::class, 'toggle'])->name('trusted-farmers.toggle');

        Route::get('/premium-verifications', [SubscriptionAdminController::class, 'index'])->name('premium-verifications.index');

        Route::get('/chat-moderation', [App\Http\Controllers\Admin\AdminChatController::class, 'dashboard'])->name('chat.dashboard');
        Route::get('/chat-moderation/reports/{report}', [App\Http\Controllers\Admin\AdminChatController::class, 'showReport'])->name('chat.report.show');
        Route::post('/chat-moderation/reports/{report}/resolve', [App\Http\Controllers\Admin\AdminChatController::class, 'resolveReport'])->name('chat.report.resolve');
        Route::post('/users/{user}/status', [App\Http\Controllers\Admin\AdminChatController::class, 'toggleUserStatus'])->name('users.status.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

