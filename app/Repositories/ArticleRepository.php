<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\IArticle;

class ArticleRepository implements IArticle
{

    public function getArticlesWithMedia()
    {
       return Article::with('media')->latest()->get();
    }

    public function delete($article)
    {
        DB::beginTransaction();

        try {
            
            $article->delete();
            DB::commit();
            return true;
        } catch (\Exception $ex) {

            DB::rollback();
            return $ex;
        }
    }

    public function storeArticle($data)
    {
        
        DB::beginTransaction();

        try {

            $article = Article::create([
                'type' => $data['type'],
                'heading' => $data['heading'],
                'content' => $data['content'],
            ]);

            if ($article) {
                if (isset($data['header_image'])) {
                    $headerImageTitle = $this->getImageTitle($data['header_image']);
                    $headerImagePath = $data['header_image']->storeAs('articles/'.$article->id, str_replace(' ', '_', $headerImageTitle), 'public');

                    $article->update([
                        'header_image' => $headerImagePath,
                    ]);
                }

                if (isset($data['media'])) {
                    $allowedfileExtension=['pdf','jpg','jpeg','png'];
                    
                    foreach ($data['media'] as $key => $media) {
                        $fileExtension = $media->getClientOriginalExtension();
                        $validExtension = in_array($fileExtension, $allowedfileExtension);
        
                        if ($validExtension) {
                            $this->createArticleMedia($media, $article);
                        }
                    }
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex;
        }
    }

    private function getImageTitle($headerImage)
    {
        return time() . '_' .$headerImage->getClientOriginalName();
    }

    private function createArticleMedia($media, $article)
    {
        try {
            $mediaTitle = $this->getImageTitle($media);
            $mediaPath = $media->storeAs('articles/'.$article->id.'/media', str_replace(' ', '_', $mediaTitle), 'public');

            $article->media()->create([
                'file_name' => $mediaTitle,
                'file_path' => $mediaPath
            ]);

            return true;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
