<?php

namespace App\Http\Controllers\Api\Lecture;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Services\LectureService;
use Illuminate\Http\Request;

class LectureController extends BaseController
{
    private $lectureService;

    public function __construct(LectureService $lectureService) {
       $this->lectureService = $lectureService;
    }

    public function index()
    {
        return $this->success($this->lectureService->getAllLecture());
    }

    public function show($id)
    {
        return $this->success($this->lectureService->getLectureById($id));
    }

    public function create(Request $request)
    {
        $lecture = new Lecture();
        $lecture->name = $request->input('name');
        $lecture->duration = $request->input('duration');
        $lecture->subject_id = $request->input('subject_id');
        // Lưu các thông tin khác của bài thi

        $lecture->save();

        return response()->json(['message' => 'Bài thi đã được thêm mới'], 201);
    }
}
