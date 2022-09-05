<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IAdmission;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Admission\CreateAdmissionRequest;

class AdmissionController extends Controller
{
    private $admissionRepository;

    public function __construct(IAdmission $admissionRepository)
    {
        $this->admissionRepository = $admissionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Admission\CreateAdmissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdmissionRequest $request)
    {
        $admission = $this->admissionRepository->createAdmission($request->validated());

        if ($admission instanceof \Exception) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $admission->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'admission applied successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
