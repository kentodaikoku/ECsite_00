<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceTestController;

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

// コンポーネント練習用
Route::get('/component', function () {
    $message = 'this is a message.';
    return view('tests.component01', compact('message'));
});
// laravelライフサイクル練習用
Route::get('/servicetest', [ServiceTestController::class, 'showService']);
Route::get('/serviceprovider', [ServiceTestController::class, 'showServiceProvider']);

require __DIR__.'/auth.php';
