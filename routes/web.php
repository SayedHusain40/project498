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
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\ChatsController;

use App\Http\Controllers\PostsController;


//admin
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TableController;



Route::get('/', function () {
    return view('dashboard');
});

Route::get('/discount', [DiscountController::class, 'index'])->name('discount.index');

Route::get('/dashboard', [DashboardController::class, 'index'])
->name('dashboard');
// ->middleware('verified')

//for martials
Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');

// chat
Route::get('/chats', [ChatsController::class, 'index'])->name('chats.index');
Route::get('chats/departments/{department}', [ChatsController::class, 'show'])->name('chats.department');


//For upload
Route::get('/up', UploadController::class)->name('up');

Route::middleware('auth')->group(function () {


    Route::post('/upload', UploadTemporaryFileController::class);
    Route::delete('/delete', DeleteTemporaryFileController::class);
    Route::post('/up', StoreMaterialController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //for martials
    Route::get('/my-materials', [MaterialController::class, 'userMaterials'])->name('user.materials');
    Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->name('materials.delete');
    Route::get('/files/{file}', [MaterialController::class, 'download'])->name('files.download');
    Route::get('/materials/{material}/downloadAll', [MaterialController::class, 'downloadAll'])->name('materials.downloadAll');
    Route::post('/bookmark-toggle', [BookmarkController::class, 'toggleBookmark'])->name('bookmark.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/followed-materials', [FollowController::class, 'followedMaterials'])->name('followed.materials');
    Route::post('/follow-toggle', [FollowController::class, 'toggleFollow'])->name('follow.toggle');

    // report
    Route::post('/report/submit', [UserReportController::class, 'submit'])->name('user_report.submit');

    // chat
    Route::post('/departments/{department}/comments', [ChatsController::class, 'storeComment'])->name('comments.store');
    Route::post('/comments/{comment}/reply', [ChatsController::class, 'storeReply'])->name('replies.store');
    Route::post('/comments/{comment}/{action}', [ChatsController::class, 'likeDislikeComment'])->name('comments.likeDislike');
    Route::delete('/comments/{comment}', [ChatsController::class, 'destroy'])->name('comments.destroy');
    Route::put('/comments/{comment}', [ChatsController::class, 'update'])->name('comments.update');




    //For Posts --- EDIT NAME OF Controller !!!!!

    Route::get('/posts', [PostsController::class, 'index'])->name('posts');
    // Store a new created post
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
});

// Only for admin
Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/dashboard.blade.php', [TableController::class, 'index'])->name('admin.users');


});

require __DIR__ . '/auth.php';
