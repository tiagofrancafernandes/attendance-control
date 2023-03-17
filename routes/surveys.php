<?php

use App\Http\Controllers\Api\SurveyAnswerController;
use Illuminate\Support\Facades\Route;

Route::prefix('surveys')->name('surveys.')->group(function () {
    Route::post('/result_list', [SurveyAnswerController::class, 'surveyResultList'])->name('result_list');
    Route::post('/answers', [SurveyAnswerController::class, 'newAnswer'])->name('new_answer');
});
