<?php

namespace App\Repositories\Interfaces;

interface IPaper
{
    public function uploadPaper($request);
    public function findPaperById($paperId);
    public function updatePaper($paper, $request);
}
