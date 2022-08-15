<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ICourse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Course\CreateCourseRequest;
use App\Http\Requests\Api\Course\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{

    protected $courseRepository;

    public function __construct(ICourse $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function store(CreateCourseRequest $request, Subject $subject)
    {
        $course = $this->courseRepository->storeSubjectCourse($subject, $request->validated());

        if ($course instanceof \Exception) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => true,
                'message' => $course->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'Course created successfully',
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course = $this->courseRepository->updateSubjectCourse($course, $request->validated());

        if ($course instanceof \Exception) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => true,
                'message' => $course->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Course updated successfully',
        ], Response::HTTP_OK);
    }
}
