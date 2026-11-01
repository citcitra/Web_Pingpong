<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('home');

// Semua route di dalam sini otomatis membutuhkan login (auth)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user-dashboard', 'PingPongController@dashboard')->name('user.dashboard');
    Route::get('/riwayat-latihan', 'PingPongController@history')->name('training.history');
    Route::post('/machine/control', 'PingPongController@control')->middleware('throttle:20,1')->name('machine.control');
    
    // Dedicated STOP endpoint is not covered by the start/configure rate limit.
    Route::post('/machine/stop', 'PingPongController@stop')->name('machine.stop');
    
    Route::get('/profil', 'ProfileController@edit')->name('profile.edit');
    Route::put('/profil', 'ProfileController@update')->name('profile.update');
    Route::post('/profil/password', 'ProfileController@password')->name('profile.password');
    
    // Route Waiting List (Disatukan di sini agar rapi)
    Route::post('/waiting-list/join/{slot_id}', 'WaitingListController@join')->name('waiting-list.join');
    Route::post('/waiting-list/cancel/{id}', 'WaitingListController@cancel')->name('waiting-list.cancel');
});

// Route khusus Admin (di luar grup auth sebelumnya)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', 'AdminController@dashboard')
        ->name('admin.dashboard');

    Route::get('/users', 'AdminController@users')
        ->name('admin.users');
    
    Route::post('/users/{id}/role', 'AdminController@updateRole')
    	->name('admin.users.role');

});