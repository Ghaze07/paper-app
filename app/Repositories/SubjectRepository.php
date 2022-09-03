<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ISubject;

class SubjectRepository implements ISubject
{

    public function getAllSubjects()
    {
        return Subject::with(['papers' => fn ($query) => $query->orderBy('date', 'DESC')])
            ->latest()->get();
    }

    public function getById($id)
    {
        return Subject::where('id', $id)->with(['papers' => fn ($query) => $query->orderBy('date', 'DESC')])
                        ->get();
    }

    public function getSubjectTestimonials($subject)
    {
        $subjectWithTestimonials = Subject::with(
            [
                'testimonials' => fn ($query) => $query->inRandomOrder()->limit(10)
            ]
        )->find($subject->id);

        return $subjectWithTestimonials;
    }

    public function getAllSubjectsCourses()
    {
        return Subject::with([
            'courses' => fn ($query) => $query->with(
                ['lectures' => fn ($query) => $query->orderBy('date', 'DESC')])
            ])->latest()->get();
    }

    public function createSubjects($subjectsArray)
    {
        DB::beginTransaction();

        try {

            foreach ($subjectsArray as $item) {

                Subject::create([
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                ]);
            }

            DB::commit();

            return true;
        } catch (\Exception $ex) {

            DB::rollBack();
            return $ex;
        }
    }

    public function createSubject($data)
    {
        # code...
    }

    public function updateSubject($subject, $data)
    {
        $subject = $subject->update($data);

        return $subject;
    }

    public function deleteSubject($id)
    {
        # code...
    }
}
