<?php

namespace App\Services;

use App\Models\Question;

class AnswerService
{
    public function checkAnswers($lectureId, $answers): array
    {
        $results = [];
        $correctCount = 0;
        $totalQuestions = count($answers);

        $lectureQuestions = Question::where('lecture_id', $lectureId)->pluck('id')->toArray();

        foreach ($answers as $questionId => $selectedOptionId) {
            if (!in_array($questionId, $lectureQuestions)) {
                return [
                    'error' => 'Invalid question ID for the specified lecture'
                ];
            }

            $question = Question::findOrFail($questionId);
            $option = $question->options()->find($selectedOptionId);

            if ($option) {
                $isCorrect = $option->is_correct;
                if ($isCorrect) {
                    $correctCount++;
                }
                $results[$questionId] = [
                    'question' => $question->content,
                    'selected_option' => $option->content,
                    'is_correct' => $isCorrect,
                ];
            } else {
                $results[$questionId] = [
                    'question' => $question->content,
                    'selected_option' => null,
                    'is_correct' => false,
                ];
            }
        }

        $score = "{$correctCount}/{$totalQuestions}";

        return [
            'results' => $results,
            'score' => $score
        ];
    }
}
