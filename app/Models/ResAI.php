<?php

namespace App\Models;

use Gemini\Data\Content;
use Illuminate\Database\Eloquent\Model;
use Gemini\Laravel\Facades\Gemini;

class ResAI extends Model
{
    private $model;
    function __construct()
    {
        $this->model = Gemini::chat($model = "gemini-2.0-flash")->startChat(
            history: [
                Content::parse(part: "
                Your name are an AI helper agent for making resumes.
                Your name is Baltimore.
                You are here to assist users for making their resumes.
                ")
            ]
        );
    }
    public function getRes($prompt)
    {
        return $this->model->sendMessage("User's response: {" .
            $prompt . 
            "}. Give an appropriate response, and proceed if you think it is right, or not."
        )->text();
    }
}
