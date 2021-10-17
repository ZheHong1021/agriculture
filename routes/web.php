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


/* 登入 */
//Route::get('login', 'LoginController@show')->name('login.show');
//Route::post('login', 'LoginController@login')->name('login.login');
Route::get('/login', [App\Http\Controllers\LoginController::class, 'show'])->name('login.show');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.login');
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('login.logout');


/* 需要登入後才能檢視 */
Route::middleware(['auth'])->group(function () {

	/* 檢測報告管理 */
	Route::get('/admin', [App\Http\Controllers\ReportController::class, 'index'])->name('admin.index');
	Route::get('/admin/report', [App\Http\Controllers\ReportController::class, 'index'])->name('admin.report.index');
	Route::get('/admin/report/create', [App\Http\Controllers\ReportController::class, 'create'])->name('admin.report.create');
	Route::get('/admin/report/upload', [App\Http\Controllers\ReportController::class, 'upload'])->name('admin.report.upload');
	Route::post('/admin/report/upload', [App\Http\Controllers\ReportController::class, 'storeFile'])->name('admin.report.storeFile');
	Route::post('/admin/report', [App\Http\Controllers\ReportController::class, 'store'])->name('admin.report.store');
	Route::get('/admin/report/{id}/edit', [App\Http\Controllers\ReportController::class, 'edit'])->name('admin.report.edit')->where('id', '[0-9]+');
	Route::patch('/admin/report/{id}', [App\Http\Controllers\ReportController::class, 'update'])->name('admin.report.update')->where('id', '[0-9]+');
	Route::delete('/admin/report/{id}', [App\Http\Controllers\ReportController::class, 'destroy'])->name('admin.report.destroy')->where('id', '[0-9]+');

	/* 平均測值管理 */
	Route::get('/admin/report/average', [App\Http\Controllers\AverageController::class, 'index'])->name('admin.report.average.index');
	Route::post('/admin/report/average', [App\Http\Controllers\AverageController::class, 'store'])->name('admin.report.average.store');

	/* 使用者管理 */
	Route::get('/admin/user', [App\Http\Controllers\UserController::class, 'index'])->name('admin.user.index');
	// Route::get('/admin/user/create', 'UserController@create')->name('admin.user.create');
	Route::get('/admin/user/create', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('admin.user.create');
	//Route::post('/admin/user', 'UserController@store')->name('admin.user.store');
	Route::post('/admin/user', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('admin.user.store');
	Route::get('/admin/user/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.user.edit')->where('id', '[0-9]+');
	Route::patch('/admin/user/{id}/edit', [App\Http\Controllers\UserController::class, 'update'])->name('admin.user.update')->where('id', '[0-9]+');
	Route::delete('/admin/user/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('admin.user.delete')->where('id', '[0-9]+');
	
	Route::get('/admin/user/password/{id}/reset', [App\Http\Controllers\UserController::class,'passwordReset'])->name('admin.user.password.reset')->where('id', '[0-9]+');

	/* 檢視各項檢測報告 */
	Route::get('/', [App\Http\Controllers\ReadController::class, 'index'])->name('home.index');
	Route::get('/report', [App\Http\Controllers\ReadController::class , 'index'])->name('report.index');
	Route::post('/api/report/{info_id}', [App\Http\Controllers\ReadController::class , 'getReportById'])->name('api.report.show')->where('info_id', '[0-9]+');
	Route::post('/api/report', [App\Http\Controllers\ReadController::class , 'getReport'])->name('api.report.index');

	/* 修改密碼 */
	Route::get('/user/password', [App\Http\Controllers\UserController::class, 'showPasswordForm'])->name('admin.user.password.show');
	Route::patch('/user/password', [App\Http\Controllers\UserController::class, 'passwordUpdate'])->name('admin.user.password.update');
});	