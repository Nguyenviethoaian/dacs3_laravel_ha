<?php

namespace App\Services;
use App\Models\Question;

class QuestionService
{
    /**
     * get all subjects
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllQuestion($lectureId)
    {
        return Question::with('options')->where('lecture_id', $lectureId)->get();
    }
}