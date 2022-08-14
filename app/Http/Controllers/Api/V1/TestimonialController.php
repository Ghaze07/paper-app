<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ITestimonial;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Testimonial\CreateTestimonialRequest;
use App\Http\Requests\Api\Testimonial\UpdateTestimonialRequest;
use App\Models\Testimonial;

class TestimonialController extends Controller
{

    protected $testimonialRepository;

    public function __construct(ITestimonial $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    public function store(CreateTestimonialRequest $request)
    {
        $testimonial = $this->testimonialRepository->storeSubjectTestimonial($request->subject_id, $request->validated());

        if ($testimonial instanceof \Exception) {

            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => true,
                'message' => $testimonial->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'Testimonial created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $updatedTestimonial = $this->testimonialRepository->updateSubjectTestimonial($testimonial, $request->subject_id, $request->validated());

        if ($updatedTestimonial instanceof \Exception) {

            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => true,
                'message' => $updatedTestimonial->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Testimonial updated successfully'
        ], Response::HTTP_OK);
    }

    public function delete(Testimonial $testimonial)
    {
        $testimonialDeleted = $this->testimonialRepository->deleteSubjectTestimonial($testimonial);

        if ($testimonialDeleted instanceof \Exception) {

            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => true,
                'message' => $testimonialDeleted->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Testimonial deleted successfully'
        ], Response::HTTP_OK);
    }
}
