<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login-v1');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {

    Route::middleware(['web','auth'])
        // ->prefix('admin')
        ->group(__DIR__ . '/admin.php');
// });
