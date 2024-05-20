<?php

namespace App\Services;

use App\Models\Lecture;

class LectureService
{
    /**
     * get all lecture
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllLecture()
    {
        return Lecture::with('questions.options')->get();
    }

    /**
     * get subject by id
     *
     * @param int $id
     * @return Lecture|null
     */
    public function getLectureById($id)
    {
        return Lecture::with('questions.options')->findOrFail($id);
    }
}