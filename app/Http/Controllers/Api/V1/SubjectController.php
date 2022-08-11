<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\ISubject;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Subject\CreateSubjectsRequest;

class SubjectController extends Controller
{
    protected $subjectRepository;

    public function __construct(ISubject $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function storeSubjects(CreateSubjectsRequest $request)
    {
        $subjects = $this->subjectRepository->createSubjects($request->subjects);

        if($subjects instanceof \Exception) {

            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $subjects->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
            
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'Subjects created successfully'
        ], Response::HTTP_CREATED);
    }
}
