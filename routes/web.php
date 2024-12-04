<?php

use App\Http\Controllers\AnnouncementController;
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
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdditionalInfoController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserUploadsController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\announcementsController;
use App\Http\Controllers\ModerateController;


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

// Dissections
Route::get('/departments/questions', [QuestionController::class, 'index'])->name('chats.index');
Route::get('/departments/{department}/questions', [QuestionController::class, 'show'])->name('chats.department');

Route::middleware('auth')->group(function () {

    // feedback 
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::get('/up', UploadController::class)->name('up');
    Route::post('/upload', UploadTemporaryFileController::class);
    Route::delete('/delete', DeleteTemporaryFileController::class);
    Route::post('/up', StoreMaterialController::class);

    // marketplace
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
    Route::post('/marketplace/upload', [MarketplaceController::class, 'store'])->name('marketplace.upload');
    Route::get('/upload/marketplace', [MarketplaceController::class, 'showUploadForm'])->name('marketplace.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/{id}/edit', [AdditionalInfoController::class, 'edit'])->name('profile.info');
    Route::post('/profile/{id}', [AdditionalInfoController::class, 'update'])->name('additional-info.update');

    //user uploads
    Route::get('/my-uploads', [UserUploadsController::class, 'index'])->name('user.materials');
    Route::delete('my-uploads/materials/{id}', [UserUploadsController::class, 'destroyMaterial'])->name('materials.destroy');
    Route::delete('my-uploads/marketplace/{id}', [UserUploadsController::class, 'destroyMarketplaceItem'])->name('marketplace.destroy');
    Route::delete('my-uploads/study-sessions/{id}', [UserUploadsController::class, 'destroyStudySession'])->name('study-sessions.destroy');
    Route::delete('my-uploads/restaurants/{id}', [UserUploadsController::class, 'destroyRestaurant'])->name('restaurants.destroy');
    Route::delete('my-uploads/announcements/{id}', [UserUploadsController::class, 'destroyAnnouncement'])->name('announcements.destroy'); // New route for deleting announcements


    //for martials
    Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->name('materials.delete');
    Route::get('/files/{file}', [MaterialController::class, 'download'])->name('files.download');
    Route::get('/materials/{material}/downloadAll', [MaterialController::class, 'downloadAll'])->name('materials.downloadAll');
    Route::post('/bookmark-toggle', [BookmarkController::class, 'toggleBookmark'])->name('bookmark.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/followed-materials', [FollowController::class, 'followedMaterials'])->name('followed.materials');
    Route::post('/follow-toggle', [FollowController::class, 'toggleFollow'])->name('follow.toggle');

    // report
    Route::post('/report/submit', [UserReportController::class, 'submit'])->name('user_report.submit');

    // Dissections
    Route::post('/departments/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::post('/departments/questions/{question}/replies', [QuestionController::class, 'storeReply']);
    Route::put('/departments/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::put('/departments/questions/{question}/replies/{reply}', [QuestionController::class, 'updateReply'])->name('replies.update');
    Route::post('/questions/{question}/like', [QuestionController::class, 'like']);
    Route::post('/questions/{question}/dislike', [QuestionController::class, 'dislike']);
    Route::post('/replies/{reply}/like', [QuestionController::class, 'likeReply']);
    Route::post('/replies/{reply}/dislike', [QuestionController::class, 'dislikeReply']);
    Route::delete('/questions/{question}', [QuestionController::class, 'destroyQuestion'])->name('questions.destroy');
    Route::delete('/replies/{reply}', [QuestionController::class, 'destroyReply'])->name('replies.destroy');
    Route::post('/report', [QuestionController::class, 'reportContent']);

    //user profile
    Route::post('/users/profile', [UserProfileController::class, 'profile'])->name('users.profile');

    //study session
    Route::get('/study-sessions', [StudySessionController::class, 'index'])->name('study-sessions.index');
    Route::get('/study-sessions/create', [StudySessionController::class, 'create'])->name('study-sessions.create');
    Route::post('/study-sessions', [StudySessionController::class, 'store'])->name('study-sessions.store');

    //announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

    //Moderate Reports
    Route::get('/moderate/reports', [ModerateController::class, 'index'])->name('moderate.index');
    Route::post('/moderate/reports/allow/{type}/{id}', [ModerateController::class, 'allow'])->name('moderate.allow');
    Route::delete('/moderate/reports/delete/{type}/{id}', [ModerateController::class, 'delete'])->name('moderate.delete');
    Route::get('/moderate/view/{type}/{id}', [ModerateController::class, 'view'])->name('moderate.view');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('/discussions/{discussion}', [QuestionController::class, 'department'])->name('discussions.department');


    //restaurants
    Route::resource('restaurants', RestaurantController::class);

});
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

// Only for admin
Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/dashboard.blade.php', [TableController::class, 'index'])->name('admin.users');


});

require __DIR__ . '/auth.php';
