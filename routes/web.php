<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceTestController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;

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
    return view('user.welcome');
});

// Route::get('/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth:users'])->name('dashboard');

Route::middleware('auth:users')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
    Route::get('show/{item}', [ItemController::class, 'show'])->name('items.show');
});

Route::prefix('cart')->middleware('auth:users')->group(function(){
    Route::post('add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('delete/{item}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// コンポーネント練習用
Route::get('/component', function () {
    $message = 'this is a message.';
    return view('tests.component01', compact('message'));
});
// laravelライフサイクル練習用
Route::get('/servicetest', [ServiceTestController::class, 'showService']);
Route::get('/serviceprovider', [ServiceTestController::class, 'showServiceProvider']);

require __DIR__.'/auth.php';
