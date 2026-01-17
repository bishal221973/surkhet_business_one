<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
    // return view('welcome');
    return redirect()->route('login');
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


Route::get('/process-queue', function () {
    // Processes the next available job and then stops
    Artisan::call('queue:work');
    return redirect()->back();
})->name('process-queue');
