<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TuitionController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/loginCheck', [UserController::class, 'getAuthenticatedUser']);

Route::group(['middleware' => ['jwt.verify:admin,officer']], function(){


    Route::group(['middleware' => ['jwt.verify:admin']], function(){
        Route::post('/tuition', [TuitionController::class, 'store']);
        Route::put('/tuition/{id}', [TuitionController::class, 'update']);
        Route::delete('/tuition/{id}', [TuitionController::class, 'delete']);

        Route::post('/grade', [GradeController::class, 'store']);
        Route::post('/student', [StudentController::class, 'store']);
        Route::put('/grade/{id}', [GradeController::class, 'update']);
        Route::delete('/grade/{id}', [GradeController::class, 'delete']);

        Route::post('/student/{id}', [StudentController::class, 'upload_photo']);
        Route::put('/student/{id}', [StudentController::class, 'update']);
        Route::delete('/student/{id}', [StudentController::class, 'delete']);


        Route::post('/officer', [OfficerController::class, 'store']);
        Route::put('/officer/{id}', [OfficerController::class, 'update']);
        Route::delete('/officer/{id}', [OfficerController::class, 'delete']);
        
        Route::post('/payment', [PaymentController::class, 'store']);
    });
    
    Route::get('/tuition', [TuitionController::class, 'show']);
    Route::get('/tuition/{id}', [TuitionController::class, 'detail']);
    
    Route::get('/grade', [GradeController::class, 'show']);
    
    
    Route::get('/student', [StudentController::class, 'show']);
    Route::get('/student/{id}', [StudentController::class, 'detail']);
    Route::get('/studentBill/{id}', [StudentController::class, 'detail_bill']);
    
    Route::get('/officer', [OfficerController::class, 'show']);
    
    Route::get('/payment', [PaymentController::class, 'show']);
    Route::get('/historyPayment/{id}', [PaymentController::class, 'history_payment']);
    Route::get('/studentWithTuition', [PaymentController::class, 'student_with_tuition']);
});







