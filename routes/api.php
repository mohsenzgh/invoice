<?php

use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SMSController;

Route::post('/send-verification-code', [SMSController::class, 'sendVerificationCode']);
Route::post('/verify-code', [SMSController::class, 'verifyCode']);

Route::post('/request-preview', [PreviewController::class, 'requestPreview']);
Route::post('/confirm-details', [ConfirmController::class, 'confirmDetails']);
Route::get('/generate-pdf/{order_id}', [PdfController::class, 'generatePdf']);

