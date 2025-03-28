<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ResAICont;
use App\Models\ResAI;

Route::get('/', function(){
    return view('welcome');
});

Route::post('/getRes', [ResAICont::class, 'getRes']);

Route::post('/clearChat', function(){
    session()->forget('chat');
});

Route::post('/getTex', function(){
    $pdf = base64_encode(file_get_contents(ResAI::getDoc()));
    return response()->json(['pdf' => $pdf]);
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
