<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// TaskController.php内の各メソッドが使用できるようにした
use App\Http\Controllers\TaskController;
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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// TaskController.php内の各メソッドが使用できるようにした
Route::resource('tasks',TaskController::class);
// --上記は下記と同様---------
// Route::get('/',[TaskController::class,'index']);//一覧表示
// Route::post('/create',[TaskController::class,'create']);//タスク追加
// Route::post('/edit',[TaskController::class,'edit']);//タスク更新
// Route::post('/delete',[TaskController::class,'delete']);//タスク削除
// ---------------------------
require __DIR__.'/auth.php';
