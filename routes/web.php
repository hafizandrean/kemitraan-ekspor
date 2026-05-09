<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

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
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Eksportir ajukan kerja sama
    Route::post('/apply/{product}', [PartnershipController::class, 'apply']);

    // Petani lihat request
    Route::get('/requests', [PartnershipController::class, 'requests']);

    // Petani accept / reject
    Route::post('/requests/{id}/accept', [PartnershipController::class, 'accept']);
    Route::post('/requests/{id}/reject', [PartnershipController::class, 'reject']);

    // Product CRUD dengan validasi
    Route::resource('products', ProductController::class);
    
    // API endpoint untuk validasi real-time
    Route::post('/products/validate', [ProductController::class, 'validateProduct']);

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
