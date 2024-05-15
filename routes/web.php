<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/user-chat/{id}', [HomeController::class, 'userChat'])->name('user-chat');

Route::get('/broadcast', [HomeController::class, 'broadcast'])->name('broadcast');
Route::post('/broadcasting', [HomeController::class, 'broadcasting'])->name('broadcasting');

Route::get('/messages/{id}', [HomeController::class, 'messages'])->name('messages');
Route::post('/message', [HomeController::class, 'message'])->name('message');
