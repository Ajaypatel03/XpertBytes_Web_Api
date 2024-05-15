<?php
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ClientReviewController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PhpmailerController;
use App\Http\Controllers\QuotesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');

    Route::resource('blogs', BlogsController::class);
    Route::resource('clients', ClientReviewController::class);
    Route::resource('employs', EmployController::class);
    Route::resource('services', ServicesController::class);
    Route::resource('contacts', ContactUsController::class);
    Route::resource('quotes', QuotesController::class);

    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__.'/auth.php';