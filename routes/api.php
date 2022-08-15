<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PaperController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\SubjectController;
use App\Http\Controllers\Api\V1\TestimonialController;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::group(['prefix' => 'v1'], function () {

        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('/', function () {
            return response()->json([
                'message' => 'Welcome to the API'
            ]);
        });

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::group(['middleware' => 'admin'], function () {

                Route::post('create-subjects', [SubjectController::class, 'store']);
                Route::post('update-subject/{subject}', [SubjectController::class, 'update']);
                Route::post('subject-paper', [PaperController::class, 'store']);
                Route::post('update-subject-paper', [PaperController::class, 'update']);

                Route::post('create-testimonials', [TestimonialController::class, 'store']);
                Route::post('update-testimonial/{testimonial}', [TestimonialController::class, 'update']);
                Route::delete('delete-testimonial/{testimonial}', [TestimonialController::class, 'delete']);

                Route::post('create-course/{subject}', [CourseController::class, 'store']);
                Route::post('update-course/{course}', [CourseController::class, 'update']);
            });
        });

        Route::get('subjects', [SubjectController::class, 'index']);
        Route::get('subject-testimonials/{subject}', [SubjectController::class, 'getSubjectTestimonials']);
    });
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found.'
    ], 404);
});
