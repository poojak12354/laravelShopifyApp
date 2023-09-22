<?php

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

Route::get('/', [App\Http\Controllers\QuotesController::class, 'index'])->middleware(['verify.shopify'])->name('home');

// Route::get('/authenticate', function () {
//     return view('authenticate');
// })->middleware(['verify.shopify'])->name('home');
Auth::routes();
// route::get('/admin' , function(){
//     return redirect('admin/dashboard');
// });
//Route::prefix('admin')->middleware(['verify.shopify'])->group(function(){
    //Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/get-quotes', [App\Http\Controllers\QuotesController::class, 'index'])->name('quotes');
    Route::post('/send-mail', [App\Http\Controllers\QuotesController::class, 'send'])->name('sendemail');
    Route::post('/send-payment-link', [App\Http\Controllers\PaymentController::class, 'sendPayLink'])->name('sendpaymentlink');
    Route::get('/view-images/{quote_id}', [App\Http\Controllers\ImageController::class, 'quoteImages']);
    Route::post('/upload-media/{quote_id}', [App\Http\Controllers\ImageController::class, 'uploadImages']);
    Route::post('/send-update', [App\Http\Controllers\ImageController::class, 'sendEmail']);
    Route::post('/delete-image', [App\Http\Controllers\ImageController::class, 'deleteImages']);
//});


route::get('/makepayment/{token}' , [App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
Route::post('spprocess', [App\Http\Controllers\StripePaymentController::class, 'stripePost'])->name('payment.post');
Route::get('/thank-you/{token}', [App\Http\Controllers\PaymentController::class, 'thankyou'])->name('thankyou');