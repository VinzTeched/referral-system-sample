<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReferralController;

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
})->middleware(['auth'])->name('dashboard');

Route::get('referral', [ReferralController::class, 'index'])
                ->name('login');
Route::post('referral', [ReferralController::class, 'store'])
                ->name('store.refer');
Route::get('/referral-status/{type}', [ReferralController::class, 'referralStatusUpdate'])
                ->name('referral.status');

require __DIR__.'/auth.php';
