<?php


use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use Auth\LoginController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route for all providers login
// Route::get('login/{provider}','Auth\LoginController@redirectToProvider');
// Route::get('login/{provider}/callback','Auth\LoginController@handleProviderCallback');

Route::get('login/{provider}',[LoginController::class,'redirectToProvider'])->name('login.Provider');
Route::get('login/{provider}/callback',[LoginController::class,'handleProviderCallback'])->name('login.Callback');

require __DIR__.'/auth.php';
