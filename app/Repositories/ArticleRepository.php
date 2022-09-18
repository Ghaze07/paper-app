<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

                    Storage::disk('articles')->put(str_replace(' ', '_', $headerImageTitle), file_get_contents($data['header_image']));
                    $article->update([
                        'header_image' => 'articles/'.$headerImageTitle,
                    ]);
                }

                if (isset($data['media'])) {
                    $allowedfileExtension=['pdf','jpg','jpeg','png', 'PNG'];
                    
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
            Storage::disk('articles')->put(str_replace(' ', '_', $mediaTitle), file_get_contents($media));
            $article->media()->create([
                'file_name' => $mediaTitle,
                'file_path' => 'articles/'.$mediaTitle
            ]);

            return true;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
