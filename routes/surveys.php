<?php

use App\Http\Controllers\Api\SurveyAnswerController;
use App\Http\Controllers\Api\SurveyController;
use Illuminate\Support\Facades\Route;

Route::prefix('surveys')->name('surveys.')->group(function () {
    Route::match(['GET', 'POST'], '/', [SurveyController::class, 'index'])->name('index');
    Route::post('/result_list', [SurveyAnswerController::class, 'surveyResultList'])->name('result_list');
    Route::post('/answers/submit', [SurveyAnswerController::class, 'newAnswer'])->name('new_answer');
    Route::post('/answers/answered', [SurveyAnswerController::class, 'answered'])->name('answered');
});
