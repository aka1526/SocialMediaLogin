<?php


use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\GoogleController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/policy', function () {
    return view('policy');
});

Route::get('/pdpa', function () {
    return view('pdpa');
});

Route::get('/service', function () {
    return view('policy');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('auth/facebook',[FacebookController::class, 'redirect']);
Route::get('auth/facebook/callback',[FacebookController::class, 'callback']);

Route::get('auth/line',[LineController::class, 'pagelogin']);
Route::get('auth/line/callback',[LineController::class, 'pageredirect']);

Route::get('auth/google',[GoogleController::class, 'pagelogin']);
Route::get('auth/google/callback',[GoogleController::class, 'pageredirect']);



require __DIR__.'/auth.php';
