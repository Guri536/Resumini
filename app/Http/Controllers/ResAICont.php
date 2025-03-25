<?php

namespace App\Http\Controllers;

use App\Models\ResAI;
use Illuminate\Http\Request;

class ResAICont extends Controller
{
    private $model;
    function __construct() {
        $this->model = new ResAI();
        return view('welcome');
    }
    function getV(){ 
        $this->model = new ResAI();
        return view('welcome');
    }

    function getRes(){ 
        return response($this->model->getRes(request('prompt'))); 
    }
}
