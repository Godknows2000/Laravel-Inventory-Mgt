<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OrderNoteController;
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

Route::middleware(['splade'])->group(function () {
    Route::middleware('auth')->group(function () {
    Route::resource('/', DashboardController::class);
    Route::get('/home', fn () => view('home'))->name('home');
    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/users', UsersController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/stocks', StockController::class);
    Route::resource('/branches', BranchController::class);
    Route::resource('/orders', OrderController::class);
    Route::resource('/shipments', ShipmentController::class);
    Route::resource('/students', StudentController::class);
    Route::resource('/order-notes', OrderNoteController::class);
    });

    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();
});
