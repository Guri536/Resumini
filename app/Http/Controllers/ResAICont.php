<?php

namespace App\Http\Controllers;

use App\Models\ResAI;
use Illuminate\Http\Request;
use App\Providers\ResAIGem;

class ResAICont extends Controller
{
    private $model;
    function __construct() {
        $this->model = app(ResAI::class);
    }
    function getRes(Request $req){ 
        return response($this->model->getRes($req->input('prompt'))); 
    }
}
