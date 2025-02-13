<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('frontend.homepage');
Route::get('/detail', [HomeController::class, 'detail'])->name('frontend.detail');
Route::get('/contact', [HomeController::class, 'contact'])->name('frontend.contact');
Route::get('/carasewa', [HomeController::class, 'carasewa'])->name('frontend.carasewa');
Route::get('/product', [HomeController::class, 'product'])->name('frontend.product');
Route::get('/detail1', [HomeController::class, 'detail1'])->name('frontend.detail1');
Route::get('/detail2', [HomeController::class, 'detail2'])->name('frontend.detail2');
Route::get('/detail3', [HomeController::class, 'detail3'])->name('frontend.detail3');
Route::get('/sewa', [HomeController::class, 'sewa'])->name('frontend.sewa');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('frontend.tentang');


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/detail4', [HomeController::class, 'detail4'])->name('frontend.detail4');