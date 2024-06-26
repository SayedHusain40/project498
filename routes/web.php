<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\DashboardController;

use App\Http\Controllers\StoreMaterialController;
use App\Http\Controllers\DeleteTemporaryFileController;
use App\Http\Controllers\UploadTemporaryFileController;
use App\Http\Controllers\UploadController;


//admin
use App\Http\Controllers\Admin\HomeController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    //For upload
    Route::get('/up', UploadController::class)->name('up');
    Route::post('/upload', UploadTemporaryFileController::class);
    Route::delete('/delete', DeleteTemporaryFileController::class);
    Route::post('/up', StoreMaterialController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        //For Posts --- EDIT NAME OF Controller !!!!! 
        //For Posts --- EDIT NAME OF Controller !!!!! 
        Route::get('/Posts', UploadController::class)->name('Posts');

});

// Only for admin
Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
