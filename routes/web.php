<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\DashboardController;

use App\Http\Controllers\StoreMaterialController;
use App\Http\Controllers\DeleteTemporaryFileController;
use App\Http\Controllers\UploadTemporaryFileController;
use App\Http\Controllers\UploadController;

use App\Http\Controllers\DiscountController;

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\BookmarkController;

use App\Http\Controllers\PostsController;


//admin
use App\Http\Controllers\Admin\HomeController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/discount', [DiscountController::class, 'index'])->name('discount.index');


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

    //for martials
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('/materials/{material}/downloadAll', [MaterialController::class, 'downloadAll'])->name('materials.downloadAll');
    Route::post('/bookmark-toggle', [BookmarkController::class, 'toggleBookmark'])->name('bookmark.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');




    //For Posts --- EDIT NAME OF Controller !!!!! 

    Route::get('/posts', [PostsController::class, 'index'])->name('posts');
    // Store a new created post
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
});

// Only for admin
Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
