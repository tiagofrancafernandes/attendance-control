<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('__/auth')->group(function () {
    require __DIR__ . '/auth.php';
})->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

Route::middleware(['auth:sanctum'])->post(
    '/user',
    fn (Request $request) => $request->user()->returnOnly($request->input('select', []))
)->name('user_info');

require __DIR__ . '/surveys.php';
