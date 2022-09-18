<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function update($lecture, $data)
    {
        DB::beginTransaction();

        try {

            if ($data['type'] == Lecture::LECTURE_TYPE_LINK) {
                $lecture->video_url = $data['video_url'];

                $lecture->deleteExistingFile();

                $lecture->type = $data['type'];
                $lecture->file_name = null;
                $lecture->file_path = null;
            }

            if ($data['type'] == Lecture::LECTURE_TYPE_FILE) {
                $lecture->deleteExistingFile();

                $title = $data['title'] ?? $lecture->title;
                $this->uploadFile($title, $data['file']);

                $lecture->type = $data['type'];
                $lecture->file_name = $this->fileTitle;
                $lecture->file_path = $this->filePath;
            }

            $lecture->title = $data['title'] ?? $lecture->title;
            $lecture->date = $data['date'] ?? $lecture->date;
            $lecture->type = $data['course_id'];

            $lecture->save();

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

            $this->filePath = 'lectures/'.$this->fileTitle;
            Storage::disk('lectures')->put(str_replace(' ', '_', $this->fileTitle), file_get_contents($lectureFile));
            return true;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
