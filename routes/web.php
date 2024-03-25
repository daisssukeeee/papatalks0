<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserprofileController; //Add
use Illuminate\Http\Request; //Add
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return view('welcome');});

Route::get('/dashboard', function () {return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');

// // 既存の'/dashboard'のルートを削除
// Route::middleware(['auth'])->get('/dashboard', function () {
//     return view('dashboard');
// });

// // 新しい'/dashboard'のルートを追加し、home.blade.phpを表示する
// Route::middleware(['auth'])->get('/dashboard', [HomeController::class, 'index'])->name('dashboard');


Route::get('/userprofiles', [UserprofileController::class, 'index'])->name('userprofiles');

// Route::get('/dashboard', [UserProfileController::class, 'dashboard'])->name('dashboard');
Route::post('/userprofile/edit', [UserprofileController::class, 'edit'])->name('edit.userprofile');
Route::match(['get', 'post'], '/edit-profile-and-redirect-to-dashboard', [UserprofileController::class, 'edit'])
    ->name('edit.profile.and.redirect.to.dashboard');

Route::post('/userprofiles', [UserprofileController::class, 'store'])->name('userprofiles.store');
Route::get('/userprofiles/{id}/edit', [UserprofileController::class, 'edit'])->name('userprofiles.edit');
// Route::put('/userprofiles/{id}', [UserprofileController::class, 'edit'])->name('userprofiles.edit');
// Route::get('userprofiles/{id}/edit', [UserprofileController::class, 'edit'])->name('userprofiles.edit');


// Route::get('/userprofiles/new', [UserprofileController::class, 'create'])->name('userprofiles.create');
Route::get('/userprofiles/{userProfile}/edit', [UserprofileController::class, 'edit'])->name('userprofiles.edit');

//プロフィール分岐用
// Route::get('/check-profile-name', [UserprofileController::class, 'checkProfileName'])->name('checkProfileName');

// 新規プロファイル作成ページ
Route::get('/userprofiles/new', [UserprofileController::class, 'create'])->name('userprofiles.new');

// プロファイル更新ページ
// Route::get('/userprofiles/edit', [UserprofileController::class, 'edit'])->name('userprofiles.edit');
Route::get('/userprofiles/{id}/edit', [UserprofileController::class, 'edit'])->name('userprofiles.id.edit');
Route::put('/userprofiles/{id}', [UserprofileController::class, 'update'])->name('userprofiles.update');

// ホームルート、HomeController@index を使用
Route::get('/home', [HomeController::class, 'index'])->name('home');


//パパ友を探すのルート
Route::get('/find-papa', [UserprofileController::class, 'find_papa'])->name('find_papa');
// Route::get('/find-papa', [UserprofileController::class, 'find']);

// イベントの新規登録フォームを表示
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

// フォームから送信されたデータを処理
Route::post('/events', [EventController::class, 'store'])->name('events.store');

// イベント検索ページのルート
Route::get('/events/search', [EventController::class, 'search_events'])->name('events.search');


//イベント申込と削除
Route::post('/events/book/{id}', [EventController::class, 'bookEvent'])->name('book.event');
Route::delete('/events/{id}', [EventController::class, 'deleteEvent'])->name('event.delete');

//イベントチェックページ
Route::get('/events/check', [EventController::class, 'check'])->name('events.check');
Route::get('/events/check/{userId}', [EventController::class, 'check'])->name('events.check');

Route::patch('/books/approve/{id}', [EventController::class, 'approve'])->name('book.approve');

//イベントにzoom URL登録
// Route::patch('/event/{id}/zoom', 'EventController@updateZoom')->name('event.updateZoom');
Route::patch('/event/{id}/zoom', [EventController::class, 'updateZoom'])->name('event.updateZoom');

//イベントのzoom URL削除
Route::delete('/zoom/{bookId}/delete',[EventController::class, 'deleteZoom'])->name('zoom.delete');
// Route::delete('/event/{id}/zoom', [EventController::class, 'deleteZoom'])->name('event.deleteZoom');



// ユーザーのプロフィールページを表示するためのルート
Route::get('/mypage/{id}', [App\Http\Controllers\UserProfileController::class, 'show'])->name('mypage.show');

//ユーザー検索
Route::get('/user/search', [App\Http\Controllers\UserProfileController::class, 'search'])->name('user.search');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
