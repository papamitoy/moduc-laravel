<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get("/", [HomeController::class, "homeView"]);
Route::get("/subject/{id}", [HomeController::class, "subjectView"]);

Route::get('/login', [LoginController::class, "authView"])->name("login");
Route::post("/login", [LoginController::class, "loginAttempt"]);
Route::post("/register", [LoginController::class, "register"]);
Route::get("/logout", [LoginController::class, "logout"]);

Route::post("/api/createclass", [ClassController::class, "createClass"]);
