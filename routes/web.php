<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ResAI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function (Request $r) {
    return view('welcome');
})->name("chat");

Route::post('/loginC', function (Request $r) {
    $cred = $r->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($cred)) {
        $user = Auth::User();
        $r->session()->regenerate();
        return redirect()->route('chat');
    }
    return redirect()->route('login')->withErrors(['email' => "Wrong Credentials"]);
})->name('loginFromChat');

Route::post('/getRes', function (Request $r) {
    return response()->json(app(ResAI::class)->getRes($r->input("prompt"), 5, false));
});

Route::post('/clearChat', function () {
    Cache::forget("gemini_chat");
    Cache::forget("tex_doc");
    Cache::forget("res_com");
    Cache::forget("pers_info");
    Cache::forget("prof_info");
});

Route::post('getTex', function (Request $r) {
    $res = ResAI::getDoc($r->input('tex'));
    $tex = base64_encode(file_get_contents($res[1]));
    $pdf = base64_encode(file_get_contents($res[0]));
    return response()->json(['pdf' => $pdf, 'tex' => $tex]);
});

Route::get('/test', function () {
    $model = Gemini\Laravel\Facades\Gemini::generativeModel('gemini-2.0-flash');
    $res =  $model->withGenerationConfig(
        generationConfig: new Gemini\Data\GenerationConfig(
            temperature: 0.7
        )
    )->generateContent("List 5 popular cookie recipes with cooking time");
})->name('test');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
