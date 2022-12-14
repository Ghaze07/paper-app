<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/optimize', function () {
    Artisan::call('optimize');
    Artisan::call('inspire');

    return response()->json([
        'optimized' => Artisan::output()
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found.'
    ], 404);
});

require __DIR__.'/auth.php';
