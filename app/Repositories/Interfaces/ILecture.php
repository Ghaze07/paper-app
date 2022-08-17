<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;

interface ILecture
{
    public function store(Course $course, $data);
}
