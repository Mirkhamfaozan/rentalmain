<?php

use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\FrontPaymentController;
use App\Http\Controllers\FrontProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes (Public Access)
|--------------------------------------------------------------------------
*/

// Homepage and general pages
Route::get('/', [HomeController::class, 'index'])->name('frontend.homepage');
Route::get('/rental-profile/{id}', [HomeController::class, 'rentalProfile'])->name('rental.profiles');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('frontend.tentang');
Route::get('/contact', [HomeController::class, 'contact'])->name('frontend.contact');
Route::get('/carasewa', [HomeController::class, 'carasewa'])->name('frontend.carasewa');
Route::get('/notifications', [NotificationController::class, 'index'])
    ->middleware('auth')
    ->name('user.notifications');

Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->middleware('auth')
    ->name('notifications.markAsRead');
// Product frontend routes
Route::get('/product', [FrontProductController::class, 'frontendIndex'])->name('frontend.product');
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('frontend.detail');

// Guest routes (accessible without authentication)
Route::group(['prefix' => 'payment'], function () {
    // Webhook route (no authentication, as it's called by payment gateway)
    Route::post('/webhook', [FrontPaymentController::class, 'webhook'])->name('payment.webhook');

    // Payment callback route (for payment gateways that redirect back)
    Route::get('/callback', [FrontPaymentController::class, 'callback'])->name('payment.callback');
    Route::post('/callback', [FrontPaymentController::class, 'callback']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Order routes
    Route::group(['prefix' => 'order'], function () {
        Route::get('/{id}', [FrontProductController::class, 'order'])->name('frontend.order');
        Route::post('/submit', [FrontProductController::class, 'submitOrder'])->name('frontend.order.submit');
    });

    // Payment routes
    Route::group(['prefix' => 'payment'], function () {
        // Create payment form
        Route::get('/create/{orderId}', [FrontPaymentController::class, 'create'])->name('payment.create');

        // Process payment creation
        Route::post('/store/{orderId}', [FrontPaymentController::class, 'store'])->name('payment.store');

        // Show payment details
        Route::get('/{paymentId}', [FrontPaymentController::class, 'show'])->name('payment.show');

        // Manual payment confirmation (for bank transfer, etc.)
        Route::post('/confirm/{paymentId}', [FrontPaymentController::class, 'confirm'])->name('payment.confirm');

        // Cancel payment
        Route::delete('/cancel/{paymentId}', [FrontPaymentController::class, 'cancel'])->name('payment.cancel');

        // Check payment status (AJAX endpoint)
        Route::get('/status/{paymentId}', [FrontPaymentController::class, 'checkStatus'])->name('payment.status');

        // Payment success page
        Route::get('/success/{paymentId}', [FrontPaymentController::class, 'success'])->name('payment.success');

        // Payment failed page
        Route::get('/failed/{paymentId}', [FrontPaymentController::class, 'failed'])->name('payment.failed');
    });

    // User dashboard routes (if you have user accounts)
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [HomeController::class, 'dashboard'])->name('frontend.dashboard');
        Route::get('/orders', [FrontProductController::class, 'userOrders'])->name('frontend.user.orders');
        Route::get('/payments', [FrontPaymentController::class, 'userPayments'])->name('frontend.user.payments');
    });
});
/*
|--------------------------------------------------------------------------
| Dashboard Routes (Admin/Rental Access)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Main dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Product management routes (using resource controller)
        Route::resource('products', ProductController::class);

        // Additional product routes
        Route::get('/products/{product}/toggle-availability', [ProductController::class, 'toggleAvailability'])->name('products.toggle-availability');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

        Route::resource('users', UserController::class)->names([
            'index' => 'users.index',
            'create' => 'users.create',
            'store' => 'users.store',
            'show' => 'users.show',
            'edit' => 'users.edit',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
        ]);

        // Reports and analytics
        Route::get('/reports', function () {
            return view('admin.reports.index');
        })->name('reports.index');

        Route::get('/reports/products', function () {
            return view('admin.reports.products');
        })->name('reports.products');

        Route::get('/reports/revenue', function () {
            return view('admin.reports.revenue');
        })->name('reports.revenue');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    // API routes for AJAX calls
    Route::get('/products/search', [ProductController::class, 'search'])->name('api.products.search');
    Route::get('/products/{id}/availability', [ProductController::class, 'checkAvailability'])->name('api.products.availability');
});


require __DIR__ . '/auth.php';
