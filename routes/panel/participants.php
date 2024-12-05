<?php

use App\Http\Controllers\ParticipantsController;

Route::get('/', [ParticipantsController::class, 'index'])->name('participants')->middleware('rbac:participants');
Route::get('/data', [ParticipantsController::class, 'data'])->name('participants.data')->middleware('rbac:participants');
Route::get('/generate', [ParticipantsController::class, 'generate'])->name('participants.generate')->middleware('rbac:participants');
