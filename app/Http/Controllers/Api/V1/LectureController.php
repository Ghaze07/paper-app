<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Course;
use App\Models\Lecture;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ILecture;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Lecture\CreateLectureRequest;
use App\Http\Requests\Api\Lecture\UpdateLectureRequest;

class LectureController extends Controller
{
    protected $lectureRepository;

    public function __construct(ILecture $lectureRepository)
    {
        $this->lectureRepository = $lectureRepository;
    }


    public function store(CreateLectureRequest $request, Course $course)
    {
        $lecture = $this->lectureRepository->store($course, $request->validated());

        if ($lecture instanceof \Exception) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $lecture->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'Lecture created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
    }
}
