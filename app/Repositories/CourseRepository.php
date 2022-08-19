<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ICourse;

class CourseRepository implements ICourse
{
    public function storeSubjectCourse($subject, $data)
    {
        DB::beginTransaction();

        try {

            $course = $subject->courses()->create($data);
            DB::commit();
            return $course;
        } catch (\Exception $e) {

            DB::rollback();
            return $e;
        }
    }

    public function updateSubjectCourse($course, $data)
    {
        DB::beginTransaction();
        try {
            $course->update($data);
            DB::commit();
            return $course;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
