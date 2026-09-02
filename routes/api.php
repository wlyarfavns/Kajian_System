<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SpeakerController;
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/speakers', [SpeakerController::class, 'index']);
Route::post('/speakers', [SpeakerController::class, 'store']);
Route::get('/speakers/{id}', [SpeakerController::class, 'show']);
Route::put('/speakers/{id}', [SpeakerController::class, 'update']);
Route::delete('/speakers/{id}', [SpeakerController::class, 'destroy']);
