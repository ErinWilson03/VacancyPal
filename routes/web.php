<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// User auth routes
Route::post("/logout", [UserController::class, "logout"])
    ->middleware('auth')->name("logout");

Route::middleware('guest')->group(function () {
    Route::get("/register", [UserController::class, "create"])->name("register");
    Route::post("/register", [UserController::class, "store"])->name("register.store");
    Route::get("/login", [UserController::class, "login"])->name("login");
    Route::post("/login", [UserController::class, "authenticate"])->name("login.authenticate");
});

// add your application routes here
