<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FormController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Cashier\Payment;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/sepa/create', [CustomerController::class, 'createSepa'])->name('customer.createSepa');
Route::post('/sepa', [CustomerController::class, 'storeSepa'])->name('storeSepa');
// Route::post('/pay', [CustomerController::class,'paymentIntent']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/customer',CustomerController::class);
    Route::resource('/form',FormController::class);
    // Route::get('/customer/:stripe_id',[CustomerController::class,'show']);
});
require __DIR__.'/auth.php';
