<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\ResAIHelper;

class ResHelplerCont extends Controller
{
    static private $model = null;
    function __construct() {
        if(self::$model == null) self::$model = app(ResAIHelper::class);
    }
    function getRes(Request $req){ 
        return response(self::$model->getRes($req->input('prompt'))); 
    }
}
