<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ResAI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function (Request $r) {
    return view('home');
})->name('home');

Route::get('/chat', function (Request $r) {
    return view('chat');
})->name("chat");

Route::get('/features', function (Request $r) {
    return view('features');
})->name('features');

Route::get('/how', function(Request $r){
    return view('how');
})->name('how');

Route::get('/faq', function(Request $r){
    return view('faq');
})->name('faq');

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
    try {
        $res = ResAI::getDoc($r->input('tex'));
    } catch (Exception $error) {
        $tex = base64_encode(file_get_contents($error->getMessage() . '/output.tex'));
        return response()->json(['isError' => true, 'err' => array($error->getMessage(), $error->getCode()), 'tex' => $tex]);
    }
    $tex = base64_encode(file_get_contents($res . '/output.tex'));
    $pdf = base64_encode(file_get_contents($res . '/output.pdf'));
    $docx = base64_encode(file_get_contents($res . '/output.docx'));
    $html = base64_encode(file_get_contents($res . '/output.html'));
    return response()->json(['pdffile' => $res . '/output.pdf','pdf' => $pdf, 'tex' => $tex, 'docx' => $docx, 'html' => $html]);
});

Route::get('/test', function () {
    return response()->json(['res' => ResAI::getDoc(Storage::get('texTemplate.tex'))]);
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
