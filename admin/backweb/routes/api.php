<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\letterOutController;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 // Login Routes 
 Route::post('/login',[AuthController::class, 'Login']);

 // Register Routes 
Route::post('/register',[AuthController::class, 'Register']);

 // Current User Route 
Route::get('/profile',[UserController::class, 'User'])->middleware('auth:api');
 
  // Current User Route 
Route::get('/afterlogin',[UserController::class, 'User'])->middleware('auth:api');

Route::post('/store_contract', [letterOutController::class, 'storeContract']);

Route::post('/store_justification', [letterOutController::class, 'storeJustification']);

Route::post('/store_general', [letterOutController::class, 'storeGeneral']);

Route::post('/store_authority', [letterOutController::class, 'storeAuthority']);

Route::get('/documents', [letterOutController::class, 'index']);

Route::get('/documents/search', [DocumentController::class, 'search']);

Route::get('/files/{fileName}', [FileController::class, 'getFile']);

// Route::get('/view-surat/{id}', [FileController::class, 'view'])->name('view-surat');

// Route::get('/file/{file_id}', 'FileController@show')->name('file.show');

// Route::get('/file/{file_id}', [FileController::class, 'show'])->name('view-surat');

// routes/web.php
Route::get('/view-pdf/{id}', [FileController::class, 'view'])->name('documents.view');

Route::get('/users-export', [letterOutController::class, 'export']);



