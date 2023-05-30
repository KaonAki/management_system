<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

// 商品一覧表示（商品テーブルなし）
Route::get('/', [HomeController::class, 'index'])->name('home');

// ajax商品テーブル追加
Route::get('/ajax', [HomeController::class, 'indexView'])->name('home.ajax');

// キーワード検索
// Route::get('/search', [HomeController::class, 'searchProduct'])->name('searchProduct');

// メーカー選択検索
// Route::get('/companySearch', [App\Http\Controllers\HomeController::class, 'selectCompany'])->name('selectCompany');

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

// ajaxでキーワード検索を繋げる
Route::get('/products/{id}', [App\Http\Controllers\HomeController::class, "productSearchName"])->name('productSearchName');

// ajaxでメーカー検索を繋げる
Route::get('/seachCompany/{id}', [App\Http\Controllers\HomeController::class, "companySearchName"])->name('companySearchName');

// ajaxで価格検索を繋げる
Route::get('/seachPrice/{price}', [App\Http\Controllers\HomeController::class, "productSearchPrice"])->name('productSearchPrice');

// ajaxで在庫検索を繋げる
Route::get('/seachStock/{stock}', [App\Http\Controllers\HomeController::class, "productSearchStock"])->name('productSearchStock');

// ajaxで削除機能を繋げる
Route::post('/destroy/{id}', [HomeController::class, "deleteProduct"])->name('deleteProduct');