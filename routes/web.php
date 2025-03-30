<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ResAI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


Route::get('/', function(){
    return view('welcome');
});

Route::post('/getRes', function(Request $r){
    return response()->json(app(ResAI::class)->getRes($r->input("prompt"), 5, false));
});

Route::post('/clearChat', function(){
    Cache::forget("gemini_chat");
    Cache::forget("tex_doc");
    Cache::forget("res_com");
    Cache::forget("pers_info");
    Cache::forget("prof_info");
});

Route::post('getTex', function(Request $r){
    $res = ResAI::getDoc($r->input('tex'));
    $tex = base64_encode(file_get_contents($res[1]));
    $pdf = base64_encode(file_get_contents($res[0]));
    return response()->json(['pdf' => $pdf, 'tex' => $tex]);
});

Route::get('/test', function(){
    $test = "Baskwad 
    asdwdi asda
    d asiodjqw das
    d wiqdj asod
    <--Tex-Start-->" 
    . Storage::get('texTemplate.tex') . 
    "<--Tex-End-->
    akjdnaosdnaskdd aidd
    a dasda sdad adas
    d daspd";
    preg_match('/<--Tex-Start-->(.+?)<--Tex-End-->/s', $test, $res);
    echo "<script>console.log('" . json_encode(trim($res[1])) . "')</script>";
    return $res[1];
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
