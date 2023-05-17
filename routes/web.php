<?php

use Illuminate\Support\Facades\Route;

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


// ログイン画面
// Route::get('/list', [App\Http\Controllers\UsersController::class, 'showList'])->name('list');

Auth::routes();

// 商品一覧表示
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// キーワード検索
Route::get('/search', [App\Http\Controllers\HomeController::class, 'searchProduct'])->name('searchProduct');

// メーカー選択検索
Route::get('/companySearch', [App\Http\Controllers\HomeController::class, 'selectCompany'])->name('selectCompany');

// 新規登録画面に行く
Route::get('/registration', [App\Http\Controllers\HomeController::class, "newRegistration"])->name('newRegistration');

// 新規登録完了
Route::post('/complete', [App\Http\Controllers\HomeController::class, "registrationComplete"])->name('registrationComplete');

// 詳細
Route::get('/detail/{id}', [App\Http\Controllers\HomeController::class, "detailProduct"])->name('detailProduct');

// 詳細から編集画面
Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, "editProduct"])->name('editProduct');

// 編集完了
Route::put('/editComplate/{id}', [App\Http\Controllers\HomeController::class, "editCompleteProduct"])->name('editCompleteProduct');

// 削除完了
Route::post('/delete/{id}', [App\Http\Controllers\HomeController::class, "deleteProduct"])->name('deleteProduct');

// 
// Route::post('/validate', [App\Http\Controllers\HomeController::class, "validateProduct"])->name('validateProduct');

// ajaxを繋げる
// Route::get('/products', [App\Http\Controllers\HomeController::class, "productSearchName"])->name('productSearchName');