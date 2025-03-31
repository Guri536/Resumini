<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ResAI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Gemini\Data\Content;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;
use GuzzleHttp\Psr7\Response;

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
    $model = Gemini::client(getenv('GEMINI_API_KEY'))->generativeModel('gemini-2.0-flash')->withGenerationConfig(
        generationConfig: new Gemini\Data\GenerationConfig(
            responseMimeType: ResponseMimeType::APPLICATION_JSON,
            responseSchema: new Gemini\Data\Schema(
                type: DataType::ARRAY,
                items: new Gemini\Data\Schema(
                    type: DataType::OBJECT,
                    properties:[
                        'text' => new Gemini\Data\Schema(type: DataType::STRING),
                        'tex' => new Gemini\Data\Schema(type: DataType::STRING)
                    ]
                )
            )
        )
    )->startChat(
        history: [
            Gemini\Data\Content::parse(part: '        Hello Gemini, you are an AI helper, here to help users make thier Resumes.
        Your name is now, Reshumi, and you must refer to yourself as that.
        The application works by implementing a .tex document, which you will edit as per user\'s resposnse.')
        ]
    );
    $res =  $model->sendMessage("Generate me 3 tex documents, with their desc");
    $res2 = $model->sendMessage("Now, give me only one document with set variables using newcommand, and also their desc in thet text");
    return array($res->json(), $res2->json());
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
