<?php

namespace App\Repositories\Interfaces;

interface ITestimonial
{
    public function storeSubjectTestimonial($subject_id, $data);
    public function updateSubjectTestimonial($testimonial, $subject_id, $data);
    public function deleteSubjectTestimonial($testimonial);
}
