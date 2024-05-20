<?php

use App\Http\Controllers\Api\Answer\AnswerController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Question\QuestionController;
use App\Http\Controllers\Api\Subjects\SubjectController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('auth')->as('auth')->group(function(){
    Route::post('login', [AuthController::class,'login'])->name('login');
    Route::post('register', [AuthController::class,'register'])->name('register');
    Route::post('login_with_token', [AuthController::class,'loginWithToken'])->middleware('auth:sanctum')->name('login_with_token');
 
});
Route::middleware('auth:sanctum')->group(function(){
    Route::get('logout', [AuthController::class,'logout'])->name('logout');
    Route::apiResource('chat', ChatController::class)->only(['index','store','show']);
    Route::apiResource('subjects', SubjectController::class)->only(['index', 'show']);
    Route::get('get_question_by_lecture_id/{lectureId}', [QuestionController::class,'getAllQuestionByLectureId']);
    Route::post('/answer/{lectureId}', [AnswerController::class, 'answer']);
});
