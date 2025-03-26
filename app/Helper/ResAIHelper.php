<?php

namespace App\Helper;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;

class ResAIHelper{
    static private $model = null;
    public static function jsPrint($text){
        echo "<script>console.log('$text')</script>";
    }
    // public function __construct(){
    //     // ResAIHelper::jsPrint("Called");
    //     $this->model = Gemini::chat(model: "gemini-2.0-flash")->startChat(history: [Content::parse(part: "A user will give you a name.")]);
    // }
    // public function getRes($prompt){
    //     return $this->model->sendMessage($prompt)->text();
    // }
    public function __construct(){
        if(self::$model == null){
            self::$model = Gemini::chat(model: "gemini-2.0-flash")->startChat(history: [Content::parse(part: "A user will give you a name.")]);
        }
    }
    public function getRes($prompt){
        return self::$model->sendMessage($prompt)->text();
    }
};
