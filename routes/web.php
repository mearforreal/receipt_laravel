<?php

use App\Enums\ReceiptStatusEnum;
use App\Enums\ReceiptTypeEnum;
use App\Http\Controllers\ReceiptController;
use App\Models\Receipt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

// Route::resource('receipts', ReceiptController::class);

Route::middleware('auth')->group(function () {
    Route::post('/receipts', [ReceiptController::class, 'store'])->name('receipt.store');
});

Route::get('/image/{fileName}', [ReceiptController::class, 'image'])->name('receipt.image');

Route::get('/', [ReceiptController::class, 'index'])->name('receipt.index');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
