<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Paper\UpdatePaperRequest;
use App\Repositories\Interfaces\IPaper;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Paper\UploadPaperRequest;

class PaperController extends Controller
{
    protected $paperRepository;

    public function __construct(IPaper $paperRepository)
    {
        $this->paperRepository = $paperRepository;
    }
    

    public function store(UploadPaperRequest $request)
    {
        $paper = $this->paperRepository->uploadPaper($request);

        if ($paper instanceof \Exception) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $paper->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'Paper uploaded successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(UpdatePaperRequest $request)
    {
        $paper = $this->paperRepository->findPaperById($request->paper_id);
        
        if ($paper instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'success' => false,
                'message' => 'Paper not found',
            ]);
        }

        $paper = $this->paperRepository->updatePaper($paper, $request);

        if ($paper instanceof \Exception) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $paper->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Paper updated successfully'
        ], Response::HTTP_OK);
    }
}
