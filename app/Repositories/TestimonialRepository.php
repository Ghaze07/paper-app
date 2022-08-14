<?php

namespace App\Repositories;

use App\Models\Testimonial;
use App\Repositories\Interfaces\ITestimonial;
use Illuminate\Support\Facades\DB;

class TestimonialRepository implements ITestimonial
{
    public function storeSubjectTestimonial($subject_id, $data)
    {
        DB::beginTransaction();
        try {

            foreach ($data['mcqs'] as $key => $mcq) {
                Testimonial::create([
                    'subject_id' => $subject_id,
                    'question' => $mcq['question'],
                    'description' => $mcq['description'] ?? null,
                    'options' => $mcq['options'],
                    'correct_option' => $mcq['correct_option'],
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $ex) {

            DB::rollback();
            return $ex;
        }
    }

    public function updateSubjectTestimonial($testimonial, $subject_id, $data)
    {
        DB::beginTransaction();

        try {

            $testimonial->update([
                'subject_id' => $subject_id,
                'question' => $data['question'] ?? $testimonial->question,
                'description' => $data['description'] ?? $testimonial->description,
                'options' => $data['options'] ?? $testimonial->options,
                'correct_option' => $data['correct_option'] ?? $testimonial->correct_option,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $ex) {

            DB::rollback();
            return $ex;
        }
    }

    public function deleteSubjectTestimonial($testimonial)
    {
        DB::beginTransaction();
        try {
            $testimonial->delete();
            DB::commit();
            return true;
        } catch (\Exception $ex) {

            DB::rollback();
            return $ex;
        }
    }
}
