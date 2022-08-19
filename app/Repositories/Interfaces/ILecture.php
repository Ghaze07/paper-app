<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;
use App\Models\Lecture;

interface ILecture
{
    public function store(Course $course, $data);

    public function update(Lecture $lecture, $data);
}
