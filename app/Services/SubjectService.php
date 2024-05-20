<?php

namespace App\Services;

use App\Models\Subject;

class SubjectService
{
    /**
     * get all subjects
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllSubjects()
    {
        return Subject::all();
    }

    /**
     * get subject by id
     *
     * @param int $subjectId
     * @return Subject|null
     */
    public function getSubjectById($subjectId)
    {
        return Subject::with('lectures')->findOrFail($subjectId);
    }
}