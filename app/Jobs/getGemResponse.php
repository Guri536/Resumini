<?php

namespace App\Jobs;

use App\Models\ResAI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class getGemResponse implements ShouldQueue
{
    use Queueable;
    private $model;
    private $prompt;
    /**
     * Create a new job instance.
     */
    public function __construct(ResAI $model, String $prompt)
    {
        $this->model = $model;
        $this->prompt = $prompt;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $response = $this->model->getRes($this->prompt);
        echo $response;
    }
}
