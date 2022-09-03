<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Repositories\Interfaces\IArticle;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\Article\CreateArticleRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    private $articleRepository;

    public function __construct(IArticle $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = $this->articleRepository->getArticlesWithMedia();

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'articles' => ArticleResource::collection($articles),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticleRequest $request)
    {
        $article = $this->articleRepository->storeArticle($request->validated());

        if ($article instanceof \Exception) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $article->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'success' => true,
            'message' => 'Article created successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $articleDeleted = $this->articleRepository->delete($article);

        if ($articleDeleted instanceof \Exception) {

            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => true,
                'message' => $articleDeleted->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Article deleted successfully'
        ], Response::HTTP_OK);
    }
}
