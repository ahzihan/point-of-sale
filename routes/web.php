<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenVerificationMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//Web API Routes
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);

//After Authentication
Route::get('/user-details', [UserController::class, 'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update', [UserController::class, 'UserUpdate'])->middleware([TokenVerificationMiddleware::class]);


//User Logout
Route::get('/userLogout', [UserController::class, 'UserLogout']);

// Page Routes
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage']);
Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/userProfile', [UserController::class, 'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/customerPage', [CustomerController::class, 'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage', [CategoryController::class, 'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/unitPage', [UnitController::class, 'UnitPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage', [ProductController::class, 'ProductPage'])->middleware([TokenVerificationMiddleware::class]);


//After Authentication
Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);

//Customer Api
Route::get('/list-customer', [CustomerController::class, 'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-customer', [CustomerController::class, 'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/edit-customer", [CustomerController::class, 'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-customer', [CustomerController::class, 'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-customer', [CustomerController::class, 'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);



//Category Api
Route::get('/list-category', [CategoryController::class, 'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-category', [CategoryController::class, 'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/edit-category", [CategoryController::class, 'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-category', [CategoryController::class, 'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-category', [CategoryController::class, 'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);



//Unit Api
Route::get('/list-unit', [UnitController::class, 'UnitList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-unit', [UnitController::class, 'UnitCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/edit-unit", [UnitController::class, 'UnitByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-unit', [UnitController::class, 'UnitUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-unit', [UnitController::class, 'UnitDelete'])->middleware([TokenVerificationMiddleware::class]);


//Product Api
Route::get('/list-product', [ProductController::class, 'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-product', [ProductController::class, 'ProductCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/edit-product', [ProductController::class, 'ProductByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-product', [ProductController::class, 'ProductUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-product', [ProductController::class, 'ProductDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/product-category', [ProductController::class, 'ProductCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/product-unit', [ProductController::class, 'ProductUnit'])->middleware([TokenVerificationMiddleware::class]);


//Dashboard API
Route::get('/total-customer', [DashboardController::class, 'TotalCustomer'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/total-category', [DashboardController::class, 'TotalCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/total-product', [DashboardController::class, 'TotalProduct'])->middleware([TokenVerificationMiddleware::class]);



