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
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\PostsController;




//admin
use App\Http\Controllers\Admin\HomeController;

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\TableController;


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
    Route::get('/files/{file}', [MaterialController::class, 'download'])->name('files.download');
    Route::get('/materials/{material}/downloadAll', [MaterialController::class, 'downloadAll'])->name('materials.downloadAll');
    Route::post('/bookmark-toggle', [BookmarkController::class, 'toggleBookmark'])->name('bookmark.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/followed-materials', [FollowController::class, 'followedMaterials'])->name('followed.materials');
    Route::post('/follow-toggle', [FollowController::class, 'toggleFollow'])->name('follow.toggle');


    //for comments
    Route::post('materials/{material}/comments', [CommentController::class, 'storeComment'])->name('comments.store');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'storeReply'])->name('replies.store');
    Route::post('/comments/{comment}/{action}', [CommentController::class, 'likeDislikeComment'])->name('comments.likeDislike');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');





    //For Posts --- EDIT NAME OF Controller !!!!! 

    Route::get('/posts', [PostsController::class, 'index'])->name('posts');
    // Store a new created post
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
});

// Only for admin
Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/dashboard', [ActivityController::class, 'showActiveUsers'])->name('admin.dashboard');
    Route::get('/chart-data', [ActivityController::class, 'getChartData']);
Route::get('/admin/dashboard', [TableController::class, 'index'])->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
