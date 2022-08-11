<?php

namespace App\Repositories\Interfaces;

interface ISubject
{
    public function getAllSubjects();
    public function getById($id);
    public function createSubject($data);
    public function createSubjects($subjectsArray);
    public function updateSubject($id, $data);
    public function deleteSubject($id);
}
