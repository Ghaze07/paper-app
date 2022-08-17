<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ILecture;

class LectureRepository implements ILecture
{

    private $fileTitle;
    private $filePath;

    public function store(Course $course, $data)
    {
        DB::beginTransaction();

        try {

            if ($data['type'] == Lecture::LECTURE_TYPE_LINK) {
                $course->lectures()->create($data);
            }

            if ($data['type'] == Lecture::LECTURE_TYPE_FILE) {
                $this->uploadFile($data['title'], $data['file']);

                $course->lectures()->create([
                    'title' => $data['title'],
                    'date' => $data['date'],
                    'type' => $data['type'],
                    'file_name' => $this->fileTitle,
                    'file_path' => $this->filePath,
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $ex) {

            DB::rollBack();
            return $ex;
        }
    }

    private function uploadFile($lectureTitle, $lectureFile)
    {
        try {
            $this->fileTitle = time() . '_' . $lectureTitle . $lectureFile->getClientOriginalName();

            $this->filePath = $lectureFile->storeAs('lectures', str_replace(' ', '_', $this->fileTitle), 'public');

            return true;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
