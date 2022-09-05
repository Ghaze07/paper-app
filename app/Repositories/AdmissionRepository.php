<?php

namespace App\Repositories;

use App\Models\Admission;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\IAdmission;

class AdmissionRepository implements IAdmission
{

    public function createAdmission($data)
    {
        DB::beginTransaction();
        try {
            $this->userHasAlreadyApplied();
            
            $admission = Admission::create($data);
            DB::commit();
            return $admission;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex;
        }
        
    }

    private function userHasAlreadyApplied()
    {
        $admission = Admission::where('user_id', auth()->user()->id)->first();

        if ($admission) {
            throw new \Exception('You have already applied for admission');
        }
    }
}
