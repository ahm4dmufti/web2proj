<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────────────────
Route::get('/', [ProductController::class, 'catalog'])->name('catalog');
Route::get('products/{product}/image', [ProductController::class, 'serveImage'])->name('products.image');
Route::get('products/{product}/images/{image}', [ProductController::class, 'serveProductImage'])->name('products.image.single');
Route::get('products/{product}/gallery', [ProductController::class, 'gallery'])->name('products.gallery');

// ── Customer routes (any authenticated user) ─────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}', [OrderController::class, 'updateInfo'])->name('orders.updateInfo');
});

// ── Admin-only routes ────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Team dashboard (kept for admin context)
    Route::prefix('{current_team}')
        ->middleware([EnsureTeamMembership::class])
        ->group(function () {
            Route::inertia('dashboard', 'dashboard')->name('dashboard');
        });

    Route::get('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])
        ->name('invitations.accept');

    // Product management
    Route::get('products/all', [ProductController::class, 'all'])->name('products.all');
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'removeImage'])->name('products.image.remove');
    Route::resource('products', ProductController::class);

    // Order management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/request-info', [AdminOrderController::class, 'requestInfo'])->name('orders.requestInfo');
        Route::patch('/orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
        Route::patch('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    });
});

require __DIR__ . '/settings.php';
