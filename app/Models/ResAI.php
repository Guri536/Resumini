<?php

namespace App\Models;

use Exception;
use Gemini\Data\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpLatex_PdfLatex;
use Illuminate\Http\Request;
use Gemini\Exceptions\ErrorException;
use Gemini\Enums\Role;
use Illuminate\Support\Facades\Cache;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;
use Gemini\Data\Schema;
use Gemini;

class ResAI extends Model
{
    private $model;
    private $template;
    private $chat;
    private $keys = array('response_text', '.tex_doc', 'generate_resume', 'personal_info', 'professional_info');

    function __construct()
    {
        $this->chat = Cache::get("gemini_chat", [Content::parse(part: '
        Hello Gemini, you are an AI helper, here to help users make thier Resumes.
        Your name is now, Reshumi, and you must refer to yourself as that.
        The application works by implementing a .tex document, which you will edit as per user\'s resposnse.
        Don\'t ask user for a .tex document. It will be loaded by the server and sent within the prompt for you to edit. The user will never see the .tex document, so don\'t mention it to the user.
        With the user\'s response and tex document, you also need to send back a few conditions for server to read and process within the response you will provide.
        For responses you will be provided a structured prompt, and you will be returing a structured response aswell.
        ', role: Role::USER)]);
        $this->template = Cache::get("tex_doc", Storage::get('texTemplate.tex'));

        $history = [];
        foreach ($this->chat as $text) {
            array_push($history, $text);
        }
        $this->model = Gemini::client(getenv('GEMINI_API_KEY'))->generativeModel('gemini-1.5-pro')->withGenerationConfig(
            generationConfig: new GenerationConfig(
                candidateCount: 1,
                maxOutputTokens: 8192,
                responseMimeType: ResponseMimeType::APPLICATION_JSON,
                responseSchema: new Schema(
                    type: DataType::ARRAY,
                    items: new Schema(
                        type: DataType::OBJECT,
                        properties: [
                            $this->keys[0] => new Schema(type: DataType::STRING),
                            $this->keys[1] => new Schema(type: DataType::STRING),
                            $this->keys[2] => new Schema(type: DataType::BOOLEAN),
                            $this->keys[3] => new Schema(type: DataType::BOOLEAN),
                            $this->keys[4] => new Schema(type: DataType::BOOLEAN),
                        ]
                    )
                )
            )
        )->startChat(history: $history);
    }

    public function getRes($prompt, $triesTillError = 5, $gotError = false)
    {
        // echo "<script>console.log('hey');</script>";
        array_push($this->chat, Content::parse(part: $prompt, role: Role::USER));
        $tries = 0;
        $isError = false;
        $resume_complete = Cache::get('res_com', 'false');
        $pers_info_provided = Cache::get('pers_info', 'false');
        $prof_info_provided = Cache::get('prof_info', 'false');
        while ($tries < $triesTillError) {
            try {
                $res = $this->model->sendMessage(
                    "
                This prompt is structred as such: 
                1. Part within <--User-Start--> and <--User-End--> is a response from the user of the application.
                2. Part within <--Instructions-Start--> and <--Instructions-End--> are requirements for the response which will be generated.
                3. Part within <--Tex-Start--> and <--Tex-End--> is the tex document which will become the resume, there are helpful comments within the document for you to make appropriate changes. DON'T USE ADDITIONAL PACKAGES. You are allowed to change the variables in the doc, and basic structure of the doc. You can also add information on behalf of the User.
                4. Part between <--Con-Start--> and <--Con-End--> are boolean conditions for you to set and read, you can only set the value as true or false. The server require those values for processing, and you also can take actions according to those variables. What those conditions mean, is also provided within '#' and '#'.
                5. THIS IS IMPORTANT: The response you need to send back, needs to strictly follow the structure as follows:
                    a. Your Response to the User needs be with 'response_text'.
                    b. The .tex document which you have edited needs to be with 'tex_doc'.
                    c. The conditions need to be returned with their respective conditions.
                Here is the prompt:
                <--User-Start-->
                    $prompt 
                <--User-End-->
                <--Instructions-Start-->
                    1. Generate a friendly response, keep it somewhat short.
                    2. Based on the user's response, continue else ask the user again for an appropritate response.
                    3. You are allowed to edit the tex document, you can add additional context to descriptions by yourself all based on user's provided info. It should be enough to fill the resume. Suppose, if the user has not added description to their Uni Experience, then you are free to do it on the user's behalf. Explain skills on user's behalf.
                    4. You are allowed to read and change the conditions, and make changes based on the conditions passed.
                    5. HIGHEST PRIORITY: Return back a response the above stated structure, which includes, user_text, tex_doc and all the conditions.
                    6. Keeping the conversation friendly is second highest priority.
                <--Instructions-End-->
                <--Tex-Start-->
                    $this->template 
                <--Tex-End-->
                <--Con-Start-->
                    generate_resume: $resume_complete #Is the resume complete and is ready to be compiled and sent to the user.#
                    personal_info: $pers_info_provided #Has user provieded all their personal info (Name, Website Links, Additional Links, Phone Number, University, Degree, Score in Uni, etc...)#
                    professional_info: $prof_info_provided #Has User provided all their professinal info (Previous Jobs, Experiences, Projects, etc...)
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
        // echo "what";
        if ($isError) return response()->json(["res" => $res, "isError" => true]);

        $res = $res->json();
        foreach ($this->keys as $key) {
            if (!array_key_exists($key, $res)) {
                if (!$gotError) {
                    return $this->getRes($prompt, 2, true);
                } else {
                    return ResAI::retError($res, "Keys Error", "Not An Appropriate Response");
                }
            }
        }

        $responseToUser = $res[$this->keys[0]];
        if ($responseToUser == "" || $responseToUser == null) {
            if (!$gotError) return $this->getRes($prompt, 1, true);
        } else return ResAI::retError($res, "Response Error", $error);

        $texDoc = $res[$this->keys[1]];
        if ($responseToUser == "" || $responseToUser == null) {
            if (!$gotError) return $this->getRes($prompt, 1, true);
        } else return ResAI::retError($res, "LaTeX Error", $error);

        $resume_complete = $res[$this->keys[2]];
        $pers_info_provided = $res[$this->keys[3]];
        $prof_info_provided = $res[$this->keys[4]];

        Cache::put('gemini_chat', $this->chat, now()->addHours(24));
        Cache::put('tex_doc', $this->chat, now()->addHours(24));
        try {
            Cache::put('res_com', $resume_complete, now()->addHours(24));
            Cache::put('pers_info', $pers_info_provided, now()->addHours(24));
            Cache::put('prof_info', $prof_info_provided, now()->addHours(24));
        } catch (Exception $error) {
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

    private static function retError($res, $errorType, $error)
    {
        return response()->json(['isError' => true, 'res' => $res, 'error' => "$errorType: " . strtok($error, '#')]);
    }
}
