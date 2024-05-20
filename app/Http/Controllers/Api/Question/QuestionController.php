<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Api\BaseController;
use App\Services\QuestionService;

class QuestionController extends BaseController
{
    private $questionService;

    public function __construct(QuestionService  $questionService) {
        $this->questionService = $questionService;
    }

    /**
     * get all question lecture id.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllQuestionByLectureId($lectureId)
    {
        $question = $this->questionService->getAllQuestion($lectureId);

        return $this->success($question);
    }
}
