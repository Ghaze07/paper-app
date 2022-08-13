<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ISubject;

class SubjectRepository implements ISubject
{
    
    public function getAllSubjects()
    {
        return Subject::with(['papers' => fn($query) => $query->orderBy('date', 'DESC')])
                        ->latest()->get();
    }

    public function getById($id)
    {
        # code...
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