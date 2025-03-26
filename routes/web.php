<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ResAICont;
use App\Http\Controllers\ResHelplerCont;
use App\Helper\ResAIHelper;

Route::get('/', function(){
    return view('welcome');
});

Route::post('/getRes', [ResAICont::class, 'getRes']);

Route::post('/clearChat', function(){
    session()->forget('chat');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
