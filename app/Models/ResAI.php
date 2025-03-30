<?php

namespace App\Models;

use Exception;
use Gemini\Data\Content;
use Illuminate\Database\Eloquent\Model;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Storage;
use PhpLatex_PdfLatex;
use Illuminate\Http\Request;
use Gemini\Exceptions\ErrorException;
use Gemini\Enums\Role;
use Illuminate\Support\Facades\Cache;

class ResAI extends Model
{
    private $model;
    private $template;
    private $chat;

    function __construct()
    {
        $this->chat = Cache::get("gemini_chat", [Content::parse(part: '
        Hello Gemini, you are an AI helper, here to help users make thier Resumes.
        Your name is now, Reshumi, and you must refer to yourself as that.
        The application works by implementing a .tex document, which you will edit as per user\'s resposnse.
        Keep the chat strictly formal.
        Don\'t ask user for a .tex document. It will be loaded by the server and sent within the prompt for you to edit.
        With the user\'s response and tex document, you also need to send back a few conditions for server to read and process within the response you will provide.
        For responses you will be provided a structured prompt, and you need to return a structured response aswell, it will all be mentioned with the prompt.
        ', role: Role::USER)]);
        $this->template = Cache::get("tex_doc", Storage::get('texTemplate.tex'));
        $history = [];
        foreach ($this->chat as $text) {
            array_push($history, $text);
        }
        $this->model = Gemini::chat($model = "gemini-2.0-flash")->startChat(history: $history);
        $this->template = Storage::get('texTemplate.tex');
    }

    public function getRes($prompt)
    {
        array_push($this->chat, Content::parse(part: $prompt, role: Role::USER));
        $tries = 0;
        $isError = false;
        $resume_complete = Cache::get('res_com', 'F');
        $pers_info_provided = Cache::get('pers_info', 'F');
        $prof_info_provided = Cache::get('prof_info', 'F');
        while ($tries < 5) {
            try {
                $res = $this->model->sendMessage(
                    "
                This prompt is structred as such: 
                1. Part within <--User-Start--> and <--User-End--> is a response from the user of the application.
                2. Part within <--Instructions-Start--> and <--Instructions-End--> are requirements for the response which will be generated.
                3. Part within <--Tex-Start--> and <--Tex-End--> is the tex document which will become the resume, there are helpful comments within the document for you to make appropriate changes. DON'T USE ADDITIONAL PACKAGES. You are allowed to change the variables in the doc, and basic structure of the doc. You can also add information on behalf of the User.
                4. Part between <--Con-Start--> and <--Con-End--> are boolean conditions for you to set and read, you can only set the value as T or F, as in True or False. The server require those values for processing, and you also can take actions according to those variables. What those conditions mean, is also provided within '#' and '#'. Here is an example: 'Resume_Complete = T/F #Is Resume complete and should be compiled and sent to the user.#'. Based on example, you can only change the boolean value.
                5. The response you need to send back, needs to strictly follow the upcoming structure. 
                    a. Your Response to User needs to be within, <--Res-Start--> and <--Res-End-->.
                    b. The .tex document which you have edited needs to be within <--Tex-Start--> and <--Tex-End-->.
                    c. The conditions need to be returned within <--Con-Start--> and <--Con-End-->, and all the conditions which will be passed to you NEED to be send back, no more, no less. Also, send response WITHOUT the descriptoins, which are within '#' and '#', DON'T ADD THOSE.
                Here is the prompt:
                <--User-Start-->
                    $prompt 
                <--User-End-->
                <--Instructions-Start-->
                    Generate a short response.
                    Based on the user's response, continue else ask the user again for an appropritate response.
                    You are allowed to edit the tex document.
                    You are allowed to read and change the variables, and make changes based on the varibales passed.
                    Return back a response the above stated structure. YOU NEED TO FOLLOW THE STRUCTURE VERY STRICTLY, IF YOU HAVE A STARTING ELEMENT, YOU NEED TO CLOSE IT. THIS SHOULD BE YOUR UPMOST PRIORITY.
                <--Instructions-End-->
                <--Tex-Start-->
                    $this->template 
                <--Tex-End-->
                <--Con-Start-->
                    IS_RESUME_COMPLETE: $resume_complete #Is the resume complete and is ready to be compiled and sent to the user.#
                    PERSONAL_INFO: $pers_info_provided #Has user provieded all their personal info (Name, Website Links, Additional Links, Phone Number, University, Degree, Score in Uni, etc...)#
                    PROFESSIONAL_INFO: $prof_info_provided #Has User provided all their professinal info (Previous Jobs, Experiences, Projects, etc...)
                <--Con-End-->
                "
                );
                $isError = false;
                break;
            } catch (ErrorException $error) {
                $res = "Failed to Launch. Error: " . strtok($error, '#');
                $isError = true;
            }
            $tries++;
        }
        if ($isError) return response()->json(['res' => $res]);

        $res = $res->text();
        try {
            preg_match('/<--Res-Start-->(.+?)<--Res-End-->/s', $res, $toUser);
            array_push($this->chat, Content::parse(part: trim($toUser[1]), role: Role::MODEL));
            Cache::put("gemini_chat", $this->chat, now()->addHours(24));
        } catch (Exception $error) {
            return response()->json(['res' => "Response Error: ". strtok($error, '#'), 'comp' => $res]);
        }

        try {
            preg_match('/<--Tex-Start-->(.+?)<--Tex-End-->/s', $res, $texDoc);
            Cache::put("tex_doc", trim($texDoc[1]), now()->addHours(24));
        } catch (Exception $error) {
            return response()->json(['res' => "Tex Document Error: " . strtok($error, '#'), 'comp' => $res]);
        }

        try {
            preg_match('/<--Con-Start-->(.+?)<--Con-End-->/s', $res, $conditions);
            $sepCon = explode("\n", trim($conditions[1]));
        } catch (Exception $error) {
            return response()->json(['res' => "Conditional Error: " . strtok($error, '#'), 'comp' => $res]);
        }

        try {
            $resume_complete = $sepCon[0][-1];
            $pers_info_provided = $sepCon[1][-1];
            $prof_info_provided = $sepCon[2][-1];
        } catch (Exception $error) {
            return response()->json(['res' => "Conditional Parse Error: " . $conditions . " : " . strtok($error, '#'), 'comp' => $res]);
        }

        try{
            Cache::put('res_com', $resume_complete, now()->addHours(24));
            Cache::put('pers_info', $pers_info_provided, now()->addHours(24));
            Cache::put('prof_info', $prof_info_provided, now()->addHours(24));
        } catch(Exception $error){
            return response()->json(['res' => "Database Addition Error: " . $conditions . " : " . strtok($error, '#')]);
        }
        if ($resume_complete == "T" || $resume_complete == 'T') {
            return response()->json(['res' => trim($toUser[1]), 'tex' => trim($texDoc[1]), 'con' => array($resume_complete, $pers_info_provided, $prof_info_provided), 'comp' => $res]);
        }
        return response()->json(['res' => trim($toUser[1]), 'con' => array($resume_complete, $pers_info_provided, $prof_info_provided), 'comp' => $res]);
    }

    public static function getDoc($tex)
    {
        $template = $tex;
        $pdflatex = new PhpLatex_PdfLatex();
        $pdflatex->setBuildDir('D:\Work\PHP\Laravell_Tests\Laravell-_ests\Resumini\storage\app\private');
        $res = $pdflatex->compilestring($template);
        $texRes = str_replace(".pdf", ".tex", $res);
        return array($res, $texRes);
    }

    private static function getFromCache($key)
    {
        $get = Cache::get($key);
        if ($get == 'T') return true;
        return false;
    }
}
