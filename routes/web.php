<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/posts', 'store')->name('store');
    Route::get('/posts/create', 'create')->name('create');

    Route::get('/posts/{post}', 'show')->name('show');
    Route::put('/posts/{post}', 'update')->name('update'); 
    Route::delete('/posts/{post}', 'delete')->name('delete'); 
    Route::get('/posts/{post}/edit', 'edit')->name('edit');
});
    
    //カレンダー↓
    
    Route::get('/calendar', [EventController::class, 'show'])->name("show");//カレンダー表示
    Route::post('/calendar/create', [EventController::class, 'create'])->name("create"); // 予定の新規追加
    Route::post('/calendar/get',  [EventController::class, 'get'])->name("get"); // DBに登録した予定を取得
    Route::put('/calendar/update', [EventController::class, 'update'])->name("update"); // 予定の更新
    Route::delete('/calendar/delete', [EventController::class, 'delete'])->name("delete");
    
    
require __DIR__.'/auth.php';
$user = Auth::user();

$id = Auth::id();