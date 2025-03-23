<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Gemini\Laravel\Facades\Gemini;

class ResAI extends Model
{
    private $model;
    function __construct() {
        $this->model = Gemini::chat($model="gemini-2.0-flash");
    }
    public function getRes(){
        return $this->model->sendMessage("Hello")->text();
    }
}
