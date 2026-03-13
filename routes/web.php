<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ShortUrlsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/s/{code}', [ShortUrlsController::class , "resolve"])->name('resolve');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [UsersController::class , "index"])->name('dashboard');

    Route::get('/invite', [UsersController::class , "invite"])->name('invite');
    Route::post('/create_invite', [UsersController::class , "store"])->name('create_invite');
    Route::get('/link', [ShortUrlsController::class , "link"])->name('link');
    Route::post('/create_link', [ShortUrlsController::class , "store"])->name('create_link');
    Route::get('/show_links', [ShortUrlsController::class , "index"])->name('show_links');

});
