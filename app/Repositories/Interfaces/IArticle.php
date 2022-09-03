<?php

namespace App\Repositories\Interfaces;

interface IArticle
{
    public function getArticlesWithMedia();
    public function storeArticle($data);
    public function delete($article);
}
