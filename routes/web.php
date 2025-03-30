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

Route::post('getTex', function(){
    $res = ResAI::getDoc();
    $tex = base64_encode(file_get_contents($res[1]));
    $pdf = base64_encode(file_get_contents($res[0]));
    return response()->json(['pdf' => $pdf, 'tex' => $tex]);
});

Route::get('/test', function(){
    $test1 = "Failed to Launch. Error: " . "Things";
    if(subStr($test1, 0, 25) == "Failed to Launch. Error: ") return "true";
    return $test1 . "<BR>";
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
