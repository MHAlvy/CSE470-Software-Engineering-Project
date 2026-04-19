<?php

use App\Http\Controllers\DonationItemController;
use App\Http\Controllers\ProfileController;
use App\Models\DonationItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimRequestController;
use App\Http\Controllers\DeliveryTaskController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $donations = DonationItem::with('donor')->where('status', 'Available')->latest()->get();
    return view('dashboard', compact('donations'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/donations/create', [DonationItemController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationItemController::class, 'store'])->name('donations.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/donations/{donation}/claim', [ClaimRequestController::class, 'create'])->name('claims.create');
    Route::post('/donations/{donation}/claim', [ClaimRequestController::class, 'store'])->name('claims.store');
    Route::get('/donations/{donation}/requests', [ClaimRequestController::class, 'index'])->name('claims.index');
    Route::post('/claims/{claim}/approve', [ClaimRequestController::class, 'approve'])->name('claims.approve');
    Route::get('/my-claims', [ClaimRequestController::class, 'myClaims'])->name('claims.my');
    Route::post('/claims/{claim}/confirm', [ClaimRequestController::class, 'confirm'])->name('claims.confirm');
    Route::get('/logistics', [DeliveryTaskController::class, 'index'])->name('deliveries.index');
    Route::post('/logistics/{donation}/accept', [DeliveryTaskController::class, 'accept'])->name('deliveries.accept');
    Route::post('/logistics/{delivery}/update', [DeliveryTaskController::class, 'updateStatus'])->name('deliveries.update');
    Route::post('/donations/{donation}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';