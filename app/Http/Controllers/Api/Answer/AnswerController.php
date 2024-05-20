<?php

namespace App\Http\Controllers\Api\Answer;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Services\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends BaseController
{
    protected $answerService;

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    public function answer(Request $request, $lectureId)
    {
        $answers = $request->input('answers');

        $result = $this->answerService->checkAnswers($lectureId, $answers);

        if (isset($result['error'])) {
            return $this->error($result['error'], 400);
        }

        return $this->success($result);
    }
    
}
