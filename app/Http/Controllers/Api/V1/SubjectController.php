<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Repositories\Interfaces\ISubject;
use App\Http\Resources\SubjectCourseResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\SubjectTestimonialResource;
use App\Http\Requests\Api\Subject\UpdateSubjectRequest;
use App\Http\Requests\Api\Subject\CreateSubjectsRequest;

class SubjectController extends Controller
{
    protected $subjectRepository;

    public function __construct(ISubject $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function index($subject_id = null)
    {
        if ($subject_id) {
            $subjects = $this->subjectRepository->getById($subject_id);
        }else {
            $subjects = $this->subjectRepository->getAllSubjects();
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'subjects' => SubjectResource::collection($subjects),
        ]);
    }

    public function getSubjectTestimonials(Subject $subject)
    {
        $subjectWithTestimonials = $this->subjectRepository->getSubjectTestimonials($subject);

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'subject' => new SubjectTestimonialResource($subjectWithTestimonials),
        ]);
    }

    public function getAllSubjectsCourses()
    {
        $subjectWithCourses = $this->subjectRepository->getAllSubjectsCourses();
        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'subject' => SubjectCourseResource::collection($subjectWithCourses),
        ]);
    }

    public function store(CreateSubjectsRequest $request)
    {
        $subjects = $this->subjectRepository->createSubjects($request->subjects);

        if ($subjects instanceof \Exception) {

            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $subjects->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'Subjects created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject = $this->subjectRepository->updateSubject($subject, $request->validated());

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Subject updated successfully'
        ], Response::HTTP_OK);
    }

    public function delete(Subject $subject)
    {
    }
}
