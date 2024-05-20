<?php

namespace App\Http\Controllers\Api\Subjects;

use App\Http\Controllers\Api\BaseController;
use App\Services\SubjectService;

class SubjectController extends BaseController
{
    private  $subjectService;
    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     * get all subject
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $subjects = $this->subjectService->getAllSubjects();

        return $this->success($subjects);
    }

    /**
     * show
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $subjects = $this->subjectService->getSubjectById($id);

        return $this->success($subjects);
    }

}
