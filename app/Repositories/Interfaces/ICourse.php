<?php

namespace App\Repositories\Interfaces;

interface ICourse
{

    public function storeSubjectCourse($subject, $data);
    public function updateSubjectCourse($course, $data);
}
