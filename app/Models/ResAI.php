<?php

namespace App\Models;

use Gemini\Data\Content;
use Illuminate\Database\Eloquent\Model;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Storage;
use PhpLatex_PdfLatex;
use Illuminate\Http\Request;
use Gemini\Exceptions\ErrorException;
use Gemini\Enums\Role;

class ResAI extends Model
{
    private $model;
    private $template;
    private $chat;
    function __construct()
    {   
        if(!session('chat')){
            session()->put('chat', [Content::parse(part:'Hello Gemini, you are an AI helper, here to help users make thier Resumes.
            Your name is now, Reshumi, and you must refer to yourself as that.
            ', role: Role::USER)]);
        }
        $this->chat = session('chat');
        $history = [];
        forEach($this->chat as $text){
            array_push($history, $text);
        }
        $this->model = Gemini::chat($model = "gemini-2.0-flash")->startChat( history: $history);
        $this->template = Storage::get('texTemplate.tex');
    }
    public function getRes($prompt)
    {
        array_push($this->chat, Content::parse(part: $prompt, role: Role::USER));
        $tries = 0;
        // try{
        //     $res = $this->model->sendMessage($prompt);
        // } catch (ErrorException $error){
        //     return "Failed To Launch. Retry.";
        // }
        while($tries < 1){
            try{
                $res = $this->model->sendMessage($prompt);
                break;
            } catch (ErrorException $error){
                $res = "Failed To Launch. Retry.";
            }
            $tries++;
        }
        if($res == "Failed To Launch. Retry.") return $res;
        $res = $res->text();
        array_push($this->chat, Content::parse(part: $res, role: Role::MODEL));
        session()->put('chat', $this->chat);
        return $res;
        // return $this->model->sendMessage("User's response: {" .
        //     $prompt . 
        //     "}. Give an appropriate response only.
        //     Don't venture off to any other topic other than resumes.
        //     If user's response is appropriate to the topic and fits the questions, then proceed, else don't and reask."
        // )->text();
    }
    public static function getDoc(){
        $template = Storage::get('texTemplate.tex');
        $pdflatex = new PhpLatex_PdfLatex();
        $pdflatex->setBuildDir('D:\Work\PHP\Laravell_Tests\Laravell-_ests\Resumini\storage\app\private');
        $res = $pdflatex->compilestring($template);
        return $res;
    }
}
