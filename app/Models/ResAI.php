<?php

namespace App\Models;

use Gemini\Data\Content;
use Illuminate\Database\Eloquent\Model;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Storage;
use PhpLatex_Parser;
use Illuminate\Http\Request;
use Gemini\Exceptions\ErrorException;

class ResAI extends Model
{
    private $model;
    private $template;
    private $chat;
    function __construct()
    {   
        if(!session('chat')){
            session()->put('chat', ['Hello Gemini, you are an AI helper, here to help users make thier Resumes.
            Your name is now, Brian, and you must refer to yourself as that.
            ']);
        }
        $this->chat = session('chat');
        $history = [];
        forEach($this->chat as $text){
            array_push($history, Content::parse(part:$text));
        }
        $this->model = Gemini::chat($model = "gemini-2.0-flash")->startChat( history: $history);
        $this->template = Storage::get('texTemplate.tex');
    }
    public function getRes($prompt)
    {
        array_push($this->chat, $prompt);
        try{
            $res = $this->model->sendMessage($prompt);
        } catch (ErrorException $error){
            return "Failed To Launch. Retry.";
        }
        $res = $res->text();
        array_push($this->chat, $res);
        session()->put('chat', $this->chat);
        return $res;
        // return $this->model->sendMessage("User's response: {" .
        //     $prompt . 
        //     "}. Give an appropriate response only.
        //     Don't venture off to any other topic other than resumes.
        //     If user's response is appropriate to the topic and fits the questions, then proceed, else don't and reask."
        // )->text();
    }
    public function getDoc(){
        $parser = new PhpLatex_Parser();
        $template = Storage::get('texTemplate.tex');
        return $parser->parse($template);
    }
}
